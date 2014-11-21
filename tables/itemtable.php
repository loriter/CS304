<html>
<head>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">

<title>ITEM TABBBBBBBBLEEEE</title>

<link href="bookbiz.css" rel="stylesheet" type="text/css">

<body>
<h1>Item Table</h1>

<?php

	$connection = new mysqli("dbserver.ugrad.cs.ubc.ca", "j4n8", "a29454113", "j4n8");

    // Check that the connection was successful, otherwise exit
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
?>
	
<h2>UPC in alphabetical order</h2>
<!-- Set up a table to view the book titles -->
<table border=1 cellpadding=0 cellspacing=0>
<!-- Create the table column headings -->
<tbody>

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
	
	if (!$result = $connection->query("SELECT upc, title, type, category, company, year, price, stock FROM item ORDER BY upc")) {
        die('There was an error running the query [' . $db->error . ']');
    }
	
    while($row = $result->fetch_assoc()){
        
       echo "<tr><td>".$row['upc']."</td>";
       echo "<td>".$row['title']."</td>";
       echo "<td>".$row['type']."</td>";
	   echo "<td>".$row['category']."</td>";
	   echo "<td>".$row['company']."</td>";
	   echo "<td>".$row['year']."</td>";
	   echo "<td>".$row['price']."</td>";
	   echo "<td>".$row['stock']."</td></tr>";
        
    }
    echo "</tbody></table>";

    // Close the connection to the database once we're done with it.
    mysqli_close($connection);
?>

<p>Back to Tables</p>
<form method="POST" action="../tables.php">
<p><input type="submit" value="Tables" name="tables"></p>
</form>
</body>
</html>