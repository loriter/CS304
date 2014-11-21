<html>
<head>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">
<title>Manager</title>

<body>
<h1>What do you want to do?</h1>

<?php

	$connection = new mysqli("dbserver.ugrad.cs.ubc.ca", "j4n8", "a29454113", "j4n8");

    // Check that the connection was successful, otherwise exit
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
		if(isset($_POST["delivery"]) && $_POST["delivery"] == "SetDelivery") {
			
			$receiptid = $_POST["receiptID"];
			$date = $_POST["new_DeliveryDate"];
			
			$qry = "SELECT * FROM orders WHERE receiptid = ".$receiptid;
			
			if (!$result = $connection->query($qry)) {
				die('There was an error running the query [' . $db->error . ']');
			}
			
			if($row = $result->fetch_assoc()) {
				$updateqry = "UPDATE orders SET delivereddate = '".$date."' WHERE receiptid = ".$receiptid;
				if ($connection->query($updateqry)) {
					echo "<p><b>Date updated</p></b>";
				}
				else {
				
					echo "<p><b>Invalid Date entered</p></b> ".$connection->error;
				}
			}
			else {
			
				echo "<p><b>ReceiptID does not exist</p></b>";
			}
		}
	}

?>

<p>Manage Items</p>
<form method="POST" action="manager/items.php">
<p><input type="submit" value="Items" name="items"></p>
</form>

<p>Top Sales</p>
<form method="POST" action="manager/topsales.php">
<p><input type="submit" value="TopSales" name="topsales"></p>
</form>

<p>Process Delivery</p>
<form method="POST" action="manager/delivery.php">
<p><input type="submit" value="Delivery" name="delivery"></p>
</form>

<p>Daily Report</p>
<form method="POST" action="manager/report.php">
<p><input type="submit" value="Report" name="report"></p>
</form>

<form method="POST" action="home.php">
<input type="submit" name="home" value="Home">
</form>