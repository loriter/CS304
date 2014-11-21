<html>
<head>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">

<title>Singersssss</title>

<body>
<h1>LeadSinger Table</h1>

<?php

	$connection = new mysqli("dbserver.ugrad.cs.ubc.ca", "j4n8", "s29454113", "j4n8");

    // Check that the connection was successful, otherwise exit
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
?>
	
<h2>Name in alphabetical order</h2>
<!-- Set up a table to view the book titles -->
<table border=0 cellpadding=0 cellspacing=0>
<!-- Create the table column headings -->

<tr valign=center>
<td class=rowheader>Name</td>
<td class=rowheader>UPC</td>
</tr>

<?php
	
	if (!$result = $connection->query("SELECT name, upc FROM leadsinger ORDER BY name")) {
        die('There was an error running the query [' . $db->error . ']');
    }
	
	echo "<table>";
	
    while($row = $result->fetch_assoc()){
        
       echo "<tr><td>".$row['name']."</td>";
	   echo "<td>".$row['upc']."</td></tr>";
        
    }
    echo "</table>";

    // Close the connection to the database once we're done with it.
    mysqli_close($connection);
?>