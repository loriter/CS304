<html>
<head>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">

<title>Da Order is here</title>

<body>
<h1>Order Table</h1>

<?php

	$connection = new mysqli("dbserver.ugrad.cs.ubc.ca", "j4n8", "s29454113", "j4n8");

    // Check that the connection was successful, otherwise exit
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
?>
	
<h2>receiptId in alphabetical order</h2>
<!-- Set up a table to view the book titles -->
<table border=0 cellpadding=0 cellspacing=0>
<!-- Create the table column headings -->

<tr valign=center>
<td class=rowheader>receiptId</td>
<td class=rowheader>Date</td>
<td class=rowheader>cid</td>
<td class=rowheader>Card#</td>
<td class=rowheader>expiryDate</td>
<td class=rowheader>expectedDate</td>
<td class=rowheader>deliveredDate</td>
</tr>

<?php
	
	if (!$result = $connection->query("SELECT receiptid, date, cid, cardno, expirydate, expecteddate, deliveredate FROM order ORDER BY receiptid")) {
        die('There was an error running the query [' . $db->error . ']');
    }
	
	echo "<table>"
	
    while($row = $result->fetch_assoc()){
        
       echo "<tr><td>".$row['receiptid']."</td>";
       echo "<td>".$row['date']."</td>";
       echo "<td>".$row['cid']."</td>";
	   echo "<td>".$row['cardno']."</td>";
	   echo "<td>".$row['expirydate']."</td>";
	   echo "<td>".$row['expecteddate']."</td>";
	   echo "<td>".$row['delivereddate']."</td></tr>";
        
    }
    echo "</table>";

    // Close the connection to the database once we're done with it.
    mysqli_close($connection);
?>