<html>
<head>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">
<title>Clerk</title>

<body>Item return</body>

<?php

    // CHANGE this to connect to your own MySQL instance in the labs or on your own computer
    $connection = new mysqli("dbserver.ugrad.cs.ubc.ca", "j4n8", "a29454113", "j4n8");

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
			$retid = $_POST["receiptId"];
			$quantity = 0;
			
			$qry = "SELECT receiptid, date FROM orders WHERE receiptid = '".$receiptid."'";
		
			if (!$result = $connection->query($qry)) {
				die('There was an error running the query [' . $db->error . ']');
			}
			//No idea what I'm doing
			if($row = $result->fetch_assoc()) {
				//This if is probably really really wrong
				
				if(strtotime($date) - strtotime($row["date"]) < (15*24*60*60)) {
					$itemqry = "SELECT quantity FROM purchase_item WHERE receiptid = '".$receiptid."' AND upc = '".$upc."'";
					
					if(!$purchases = $connection->query($itemqry)) {
						die('Error query [' . $db->error . ']');
					}
					//Retrieves the quantity from purchase_item
					if($rowpurchase = $purchases->fetch_assoc()) {
						$quantity = $rowpurchase['quantity'];
					}
					//Adds to returns
					$stmt = $connection->prepare("INSERT INTO returns (retid, date, receiptid) VALUES (?,?,?)");
					$stmt->bind_param("sss", $retid, $date, $receiptid);
					$stmt->execute();
					if($stmt->error) {       
						printf("<b>Error: %s.</b>\n", $stmt->error);
					} else {
						echo "<b><p>Successfully added to returns</b></p>";
					}
					//Adds to returnitem
					$stmt2 = $connection->prepare("INSERT INTO returnitem (retid, upc, quantity) VALUES (?,?,?)");
					$stmt2->bind_param("sss", $retid, $upc, $quantity);
					$stmt2->execute();
					if($stmt2->error) {       
						printf("<b>Error: %s.</b>\n", $stmt2->error);
					} else {
						echo "<b><p>Successfully added to returnitem</p></b>";
					}
					
				}
				else {
					echo "<b>Too late to return</b>";
				}
			}
			else {
				echo "<p><b>ReceiptID invalid</b></p>";
			}
		}
	
	}
?>


<p>Enter information for returned item</p>
<form method="POST" action="clerk.php">
<table border=0 cellpadding=0 cellspacing=0>
<tr><td>Date of Return</td><td><input type="text" size=20 name="new_date"</td></tr>
<tr><td>receiptId</td><td><input type="text" size=20 name="receiptId"</td></tr>
<tr><td>Item upc</td><td><input type="text" size=20 name="upc"</td></tr>
<tr><td></td><td><input type="submit" name="return" value="Return"></td></tr>
</table>
</form>
<form method="POST" action="home.php">
<input type="submit" name="home" value="Home">
</form>