<html>
<head>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">

<title>Where Purchase at?</title>

<body>
<h1>PurchaseItem Table</h1>

<?php

	$connection = new mysqli("dbserver.ugrad.cs.ubc.ca", "j4n8", "a29454113", "j4n8");

    // Check that the connection was successful, otherwise exit
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
?>
	
<h2>ReceiptId in alphabetical order</h2>
<!-- Set up a table to view the book titles -->
<table border=1 cellpadding=0 cellspacing=0>
<!-- Create the table column headings -->

<tr valign=center>
<td class=rowheader>receiptId</td>
<td class=rowheader>upc</td>
<td class=rowheader>quantity</td>
</tr>

<?php
	
	if (!$result = $connection->query("SELECT receiptid, upc, quantity FROM purchase_item ORDER BY receiptid")) {
        die('There was an error running the query [' . $db->error . ']');
    }
	
    while($row = $result->fetch_assoc()){
        
       echo "<tr><td>".$row['receiptid']."</td>";
       echo "<td>".$row['upc']."</td>";
	   echo "<td>".$row['quantity']."</td></tr>";
        
    }
    echo "</table>";

    // Close the connection to the database once we're done with it.
    mysqli_close($connection);
?>

<p>Back to Tables</p>
<form method="POST" action="../tables.php">
<p><input type="submit" value="Tables" name="tables"></p>
</form>