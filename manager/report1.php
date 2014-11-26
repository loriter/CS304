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
<td class=rowheader>TotalIValue</td>
</tr> 


<?php
// in this code here we have to populate the table with the correct stuff=
$dadate = $_POST["new_rdate"];  // this holds the date variable 
$tValue = 0;
/*$user = 'root'; 
$pass = ''; 
$db = 'test';
$connection = new mysqli('localhost', $user, $pass, $db) or die("Unable to connect");*/
$connection = new mysqli("dbserver.ugrad.cs.ubc.ca", "j4n8", "a29454113", "j4n8");

if(!$rresult = $connection->query("SELECT I.upc, I.category, I.price, SUM(P.quantity) AS rsold, O.date
FROM Item I, Purchase_Item P, Orders O
WHERE O.date = $dadate AND I.upc = P.upc AND P.receiptId = O.receiptId
GROUP BY I.title, I.company, O.date
ORDER BY I.category, rsold")){
  echo "this query did not work1!!";
  die('There was an error running the report query');
}
while($rrow = $rresult->fetch_assoc()){
    $rprice = $rrow['price'];
    $rquantity = $rrow['rsold'];
    $totalIVal = $rquantity * $rprice;
    $tValue += $totalIVal;
    echo "<tr><td>".$rrow['upc']."</td>"; 
    echo "<td>".$rrow['category']."</td>";  
    echo "<td>".$rrow['price']."</td>";
    echo "<td>".$rrow['rsold']."</td>";
    echo "<td>".$totalIVal."</td></tr>"; 
  }
?>
<tbody>
<tr valign=right>
<td class=rowheader>TValue</td>
</tr>
<?php    
    echo "<td>".$tValue."</td></tr>";
    echo "</tbody></table>";
?>

<form method="POST" action="report.php">
<p><input type="submit" value="Back" name="Back"></p>
</html>

