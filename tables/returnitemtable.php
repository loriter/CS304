<html>
<head>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">

<title>Return yo Items</title>

<body>
<h1>ReturnItem Table</h1>

<?php

	$connection = new mysqli("dbserver.ugrad.cs.ubc.ca", "j4n8", "s29454113", "j4n8");

    // Check that the connection was successful, otherwise exit
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
?>
	
<h2>Retid in alphabetical order</h2>
<!-- Set up a table to view the book titles -->
<table border=0 cellpadding=0 cellspacing=0>
<!-- Create the table column headings -->

<tr valign=center>
<td class=rowheader>Retid</td>
<td class=rowheader>upc</td>
<td class=rowheader>quantity</td>
</tr>

<?php
	
	if (!$result = $connection->query("SELECT retid, upc, quantity FROM returnitem ORDER BY retid")) {
        die('There was an error running the query [' . $db->error . ']');
    }
	
	echo "<table>"
	
    while($row = $result->fetch_assoc()){
        
       echo "<tr><td>".$row['retid']."</td>";
       echo "<td>".$row['upc']."</td>";
	   echo "<td>".$row['quantity']."</td></tr>";
        
    }
    echo "</table>";

    // Close the connection to the database once we're done with it.
    mysqli_close($connection);
?>