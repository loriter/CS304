<html>
<head>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">

<title>Customers Yo</title>

<body>
<h1>Customer Table</h1>

<?php

	$connection = new mysqli("dbserver.ugrad.cs.ubc.ca", "j4n8", "a29454113", "j4n8");

    // Check that the connection was successful, otherwise exit
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
?>
	
<h2>UPC in alphabetical order</h2>
<!-- Set up a table to view the book titles -->
<table border=1 cellpadding=0 cellspacing=0>
<!-- Create the table column headings -->

<tr valign=center>
<td class=rowheader>cid</td>
<td class=rowheader>Password</td>
<td class=rowheader>Name</td>
<td class=rowheader>Address</td>
<td class=rowheader>Phone</td>
</tr>

<?php
	
	if (!$result = $connection->query("SELECT cid, password, name, address, phoneno FROM customer ORDER BY cid")) {
        die('There was an error running the query [' . $db->error . ']');
    }
	
    while($row = $result->fetch_assoc()){
        
       echo "<tr><td>".$row['cid']."</td>";
       echo "<td>".$row['password']."</td>";
       echo "<td>".$row['name']."</td>";
	   echo "<td>".$row['address']."</td>";
	   echo "<td>".$row['phoneno']."</td></tr>";
        
    }
    echo "</table>";

    // Close the connection to the database once we're done with it.
    mysqli_close($connection);
?>

<p>Back to Tables</p>
<form method="POST" action="../tables.php">
<p><input type="submit" value="Tables" name="tables"></p>
</form>