<html>
<head>
</head>
<title>Report Page</title>
<h1>Report</h1>
<body>
All sales for: <?php echo $_POST["new_rdate"]; ?>
</body>
<!-- Set up a table to view the book titles -->
<table border=1 cellpadding=0 cellspacing=0>
<!-- Create the table column headings -->
<tbody>
<tr valign=center>
<td class=rowheader>UPC</td>
<td class=rowheader>Category</td>
<td class=rowheader>Unit Price</td>
<td class=rowheader>Units</td>
<td class=rowheader>TotalValue</td>
</tr>

<?php
	// in this code here we have to populate the table with the correct stuff=
	$dadate = $_POST["new_rdate"];  // this holds the date variable  
	$user = 'j4n8'; 
	$pass = 'a29454113'; 
	$db = 'j4n8';
	$connection = new mysqli('dbserver.ugrad.cs.ubc.ca', $user, $pass, $db);

	if(!$rresult = $connection->query("SELECT I.upc, I.category, I.price, SUM(P.quantity) AS rsold, O.date
	FROM item I, purchase_item P, orders O
	WHERE O.date = '$dadate' AND I.upc = P.upc AND P.receiptId = O.receiptId
	GROUP BY I.title, I.company, O.date
	ORDER BY I.category, rsold")){
		die('There was an error running the report query');
		}

	$cat = null;
	$cVal = 0;
	$tVal = 0;

	while($rrow = $rresult->fetch_assoc()){
	
		if($cat != $rrow['category']){
			if($cat != null) {
				echo "<tr><td></td><td>Total</td><td></td><td></td><td>".$cVal."</td></tr>";
			}
			$cat = $rrow['category'];
			$cVal =0;
		}	
			
		$rprice = $rrow['price'];
		$rquantity = $rrow['rsold'];
		$itemVal = $rquantity * $rprice;
		$cVal += $itemVal;
		$tVal += $itemVal;
		
		echo "<tr><td>".$rrow['upc']."</td>"; 
		echo "<td>".$rrow['category']."</td>";  
		echo "<td>".$rrow['price']."</td>";
		echo "<td>".$rrow['rsold']."</td>";
		echo "<td>".$itemVal."</td></tr>"; 
	}
	echo "<tr><td></td><td>Total</td><td></td><td></td><td>".$cVal."</td></tr>";
	echo "<tr><td></td><td>Total Sales</td><td></td><td></td><td>".$tVal."</td></tr>";
    echo "</tbody></table>";
?>

<form method="POST" action="report.php">
<p><input type="submit" value="Back" name="Back"></p>
</form> 
</html>

