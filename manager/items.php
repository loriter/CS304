<html>
<head>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">

<title>Item Inventory</title>
<!--
    A simple stylesheet is provided so you can modify colours, fonts, etc.
-->
    <link href="bookbiz.css" rel="stylesheet" type="text/css">

<!--
    Javascript to submit a upc as a POST form, used with the "delete" links
-->
<script>
function formSubmit(upc) {
    'use strict';
    if (confirm('Are you sure you want to delete this title?')) {
      // Set the value of a hidden HTML element in this form
      var form = document.getElementById('delete');
      form.upc.value = upc;
      // Post this form
      form.submit();
    }
}
</script>
</head>

<body>
<h1>Manage Item Inventory</h1>
<?php
    /****************************************************
     STEP 1: Connect to the MySQL database
     ****************************************************/

    // CHANGE this to connect to your own MySQL instance in the labs or on your own computer
    $connection = new mysqli("dbserver.ugrad.cs.ubc.ca", "j4n8", "a29454113", "j4n8");

    // Check that the connection was successful, otherwise exit
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    /****************************************************
     STEP 2: Detect the user action
     ****************************************************/

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

		if (isset($_POST["submitDelete"]) && $_POST["submitDelete"] == "DELETE") {
       
			// Create a delete query prepared statement with a ? for the upc
			$stmt = $connection->prepare("DELETE FROM item WHERE upc=?");
			$deleteUpc = $_POST['upc'];
			// Bind the upc parameter, 's' indicates a string value
			$stmt->bind_param("s", $deleteUpc);
       
			// Execute the delete statement
			$stmt->execute();
          
			if($stmt->error) {
				printf("<b>Error: %s.</b>\n", $stmt->error);
			} else {
				echo "<b>Successfully deleted ".$deleteUpc."</b>";
			}
			
		} elseif (isset($_POST["submit"]) && $_POST["submit"] ==  "ADD") {
			$upc = $_POST["new_upc"];
			$title = $_POST["new_title"];
			$type = $_POST["new_type"];
			$category = $_POST["new_category"];
			$company = $_POST["new_company"];
			$year = $_POST["new_year"];
			$price = $_POST["new_price"];
			$stock = $_POST["new_stock"];
			
			$qry = "SELECT stock FROM item WHERE upc = '".$upc."'";
			if (!$result = $connection->query($qry)) {
				die('There was an error running the query [' . $db->error . ']');
			}
			
			//If item does not exist
			if($result->num_rows < 1) {
				$stmt = $connection->prepare("INSERT INTO item (upc, title, type, category, company, year, price, stock) VALUES (?,?,?,?,?,?,?,?)");
          
				// Bind the title and pub_id parameters, 'sss' indicates 3 strings
				$stmt->bind_param("ssssssss", $upc, $title, $type, $category, $company, $year, $price, $stock);
        
				// Execute the insert statement
				$stmt->execute();
          
				/*if($stmt->error) {       
					printf("<b>Error: %s.</b>\n", $stmt->error);
				} else {
					echo "<b>Successfully added ".$upc."</b>";
				}*/
			}
			//If item exists update price and stock
			else {
				$row = $result->fetch_assoc();
				$stock = $stock + $row['stock'];
				$update = "UPDATE item SET price = '".$price."', stock = '".$stock."' WHERE upc = '".$upc."'";
				if($connection->query($update) === TRUE) {
					echo "<b><p>Updated successfully</b></p>";
				}
				else {
					echo "<b><p>Update failed</b></p>";
				}
		}
    }
   }
?>

<h2>UPC in alphabetical order</h2>
<!-- Set up a table to view the book titles -->
<table border=1 cellpadding=0 cellspacing=0>
<!-- Create the table column headings -->

<tr valign=center>
<td class=rowheader>UPC</td>
<td class=rowheader>Title</td>
<td class=rowheader>Type</td>
<td class=rowheader>Category</td>
<td class=rowheader>Company</td>
<td class=rowheader>Year</td>
<td class=rowheader>Price</td>
<td class=rowheader>Stock</td>
</tr>

<?php
    /****************************************************
     STEP 3: Select the most recent list of item
     ****************************************************/

   // Select all of the book rows columns upc, title and pub_id
    if (!$result = $connection->query("SELECT upc, title, type, category, company, year, price, stock FROM item ORDER BY upc")) {
        die('There was an error running the query [' . $db->error . ']');
    }

    // Avoid Cross-site scripting (XSS) by encoding PHP_SELF (this page) using htmlspecialchars.
    echo "<form id=\"delete\" name=\"delete\" action=\"";
    echo htmlspecialchars($_SERVER["PHP_SELF"]);
    echo "\" method=\"POST\">";
    // Hidden value is used if the delete link is clicked
    echo "<input type=\"hidden\" name=\"upc\" value=\"-1\"/>";
   // We need a submit value to detect if delete was pressed 
    echo "<input type=\"hidden\" name=\"submitDelete\" value=\"DELETE\"/>";


    while($row = $result->fetch_assoc()){
        
       echo "<td>".$row['upc']."</td>";
       echo "<td>".$row['title']."</td>";
       echo "<td>".$row['type']."</td>";
	   echo "<td>".$row['category']."</td>";
	   echo "<td>".$row['company']."</td>";
	   echo "<td>".$row['year']."</td>";
	   echo "<td>".$row['price']."</td>";
	   echo "<td>".$row['stock']."</td><td>";
       
       //Display an option to delete this title using the Javascript function and the hidden upc
       echo "<a href=\"javascript:formSubmit('".$row['upc']."');\">DELETE</a>";
       echo "</td></tr>";
        
    }
    echo "</form>";

    // Close the connection to the database once we're done with it.
    mysqli_close($connection);
?>

</table>

<h2>Update Items</h2>

<!--
  /****************************************************
   STEP 5: Build the form to add a book title
   ****************************************************/
    Use an HTML form POST to add a book, sending the parameter values back to this page.
    Avoid Cross-site scripting (XSS) by encoding PHP_SELF using htmlspecialchars.

    This is the simplest way to POST values to a web page. More complex ways involve using
    HTML elements other than a submit button (eg. by clicking on the delete link as shown above).
-->

<form id="add" name="add" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <table border=0 cellpadding=0 cellspacing=0>
        <tr><td>Item UPC</td><td><input type="text" size=30 name="new_upc"</td></tr>
        <tr><td>Item Title</td><td><input type="text" size=30 name="new_title"</td></tr>
		<tr><td>Item Type</td><td><input type="text" size=30 name="new_type"</td></tr>
		<tr><td>Item Category</td><td><input type="text" size=30 name="new_category"</td></tr>
		<tr><td>Company</td><td><input type="text" size=30 name="new_company"</td></tr>
		<tr><td>Year</td><td><input type="text" size=30 name="new_year"</td></tr>
		<tr><td>Item Price</td><td><input type="text" size=30 name="new_price"</td></tr>
        <tr><td>Stock</td><td> <input type="text" size=30 name="new_stock"></td></tr>
        <tr><td></td><td><input type="submit" name="submit" border=0 value="ADD"></td></tr>
    </table>
</form>

<p>Back to Manager</p>
<form method="POST" action="../manager.php">
<p><input type="submit" value="Manager" name="manager"></p>
</form>
</body>
</html>
