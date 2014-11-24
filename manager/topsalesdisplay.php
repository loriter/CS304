<html>
<head>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">
<title>Customer Login</title>

<body>Customer Login or Registration</body>

<?php

	$connection = new mysqli("dbserver.ugrad.cs.ubc.ca", "j4n8", "a29454113", "j4n8");

    // Check that the connection was successful, otherwise exit
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if(isset($_POST["Search"]) && $_POST["Search"] == "Search") {
			$receiptarray =  array();
			$date = $_POST["new_tsalesdate"];
			$nsales = $_POST["new_nofsale"];
			
			$orderqry = "SELECT receiptid FROM orders WHERE date = '".$date."'";
			
			if (!$orderresult = $connection->query($orderqry)) {
				die('There was an error running the orders query [' . $db->error . ']');
			}
			$purchaseqry = "SELECT upc, qty FROM purchase_item WHERE receiptid = '"row['receiptid']"'";
			if (!$purchaseresult = $connection->query($orderqry) {
				die('There was an error running the orders query [' . $db->error . ']');
			}
			while($orow = $orderresult->fetch_assoc()){
				while($prow = $purchaseresult->fetch_assoc(){
					if(array_key_exists($prow[upc], $receiptarray)){
						$receiptarray[$prow[upc]] += $prow[quantity];
					}else{
					$receiptarray += array($prow[upc]=>$prow[quantity]);
					}
				}
			}
			
			for($i = 0; $i < $nsales; $i++){
				
			}
			/*
			$cid = $_POST["new_cid"];
			$pass = $_POST["new_pass"];
			$name = $_POST["new_name"];
			$add = $_POST["new_add"];
			$phone = $_POST["new_phone"];
			
			$stmt = $connection->prepare("INSERT INTO customer (cid, password, name, address, phoneno) VALUES (?,?,?,?,?)");
			//$stmt = oci_parse($connection, "INSERT INTO customer (cid, password, name, address, phoneno) VALUES (:cid, :password, :name, :address, :phoneno)");
			
			$stmt->bind_param("sssss", $cid, $pass, $name, $add, $phone);
			
			$stmt->execute();
			
			if($stmt->error) {
				printf("<p><b>Error: %s.</p></b>\n", $stmt->error);
			}
			else {
				echo "<p><b>Successfully registered </b></p>";
			}
			*/
			
		}
		else{
			echo "<p>TWISTAS <.se1></p>";
		}
	}
	
	?>


<form method="POST" action="topsales.php">
<input type="submit" name="Back" value="Back">
</form>

</body>
</html>