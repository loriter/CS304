<html>
<head>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">
<title>Much sales, such monies</title>

<body>Top Sales</body>

<?php
/*
	$user = 'root'; 
	$pass = ''; 
	$db = 'test';
	$connection = new mysqli('localhost', $user, $pass, $db) or die("Unable to connect");*/
	$connection = new mysqli("dbserver.ugrad.cs.ubc.ca", "j4n8", "a29454113", "j4n8");

?>

<h2>Top sales from highest to lowest</h2>
<table border=1 cellpadding=0 cellspacing=0>
<tr valign=center>
<td class=rowheader>Title</td>
<td class=rowheader>Company</td>
<td class=rowheader>Current stock</td>
<td class=rowheader>Copies sold</td>
</tr>

<?php
	$tsdate = $_POST["new_tsalesdate"];
	$nsales = $_POST["new_nofsale"];
	$tscounter = 0;

    // Check that the connection was successful, otherwise exitSELECT ReceiptId, date FROM Orders WHERE date = '$dadate'
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
	if(!$tsresult = $connection->query("SELECT I.title, I.company, I.stock AS totalstock, SUM(P.quantity) AS tsold, O.date
FROM Item I, Purchase_Item P, Orders O
WHERE O.date = '$tsdate' AND I.upc = P.upc AND P.receiptId = O.receiptId
GROUP BY I.title, I.company, O.date
ORDER BY tsold DESC LIMIT $nsales")){
  	echo "Sad face ";
 	 die('There was an error running the top sales query');
	}
    while($tsrow = $tsresult->fetch_assoc()){
       echo "<tr><td>".$tsrow['title']."</td>";
       echo "<td>".$tsrow['company']."</td>";
       echo "<td>".$tsrow['totalstock']."</td>";
	   echo "<td>".$tsrow['tsold']."</td></tr>";
    }
    echo "</table>";

    // Close the connection to the database once we're done with it.
    mysqli_close($connection);
	/*if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if(isset($_POST["Search"]) && $_POST["Search"] == "Search") {
			$receiptarray =  array();
			
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
			
			
		}
		else{
			echo "<p>TWISTAS <.se1></p>";
		}*/
?>
<form method="POST" action="topsales.php">
<input type="submit" name="Back" value="Back">
</form>
</html>