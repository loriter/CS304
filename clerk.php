<html>
<head>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">
<title>Clerk</title>

<body>Item return</body>

<?php
    /****************************************************
     STEP 1: Connect to the MySQL database
     ****************************************************/

    // CHANGE this to connect to your own MySQL instance in the labs or on your own computer
    $connection = new mysqli("dbserver.ugrad.cs.ubc.ca", "j4n8", "s29454113", "j4n8");

    // Check that the connection was successful, otherwise exit
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
		if(isset($_POST["return"]) && $_POST["return"] == "Return") {
		
			$receiptid = $_POST["receiptId"];
			$date = $_POST["new_date"];
			$upc = $_POST["upc"];
			$quantity = $_POST["new_quantity"];
			$retid = $receiptid;
		
			if (!$result = $connection->query("SELECT receiptid, date FROM order ORDER BY receiptid WHERE receiptid = ".$receiptid."")) {
				die('There was an error running the query [' . $db->error . ']');
			}
			//No idea what I'm doing
			if($row = $result->fetch_assoc()) {
				if($date < $row["date"] + 15) {
					//Add stuff to return tables
				}
				else {
					echo "<b>Too late to return</b>";
				}
			}
			else {
				echo "<b>ReceiptID invalid</b>";
			}
		}
	
	}
?>


<p>Enter information for returned item</p>
<form method="POST" action="clerk.php">
<table border=0 cellpadding=0 cellspacing=0>
<tr><td>Date</td><td><input type="text" size=20 name="new_date"</td></tr>
<tr><td>receiptId</td><td><input type="text" size=20 name="receiptId"</td></tr>
<tr><td>Item upc</td><td><input type="text" size=20 name="upc"</td></tr>
<tr><td>Quantity</td><td><input type="text" size=20 name="new_quantity"</td></tr>
<tr><td></td><td><input type="submit" name="return" value="Return"></td></tr>
</table>
</form>
<form method="POST" action="home.php">
<input type="submit" name="home" value="home">
</form>