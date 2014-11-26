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
<td class=rowheader>TotalCValue</td>
</tr>

<?php
// in this code here we have to populate the table with the correct stuff=
$dadate = $_POST["new_rdate"];  // this holds the date variable  
$tValue = 0;
$cVal = 0;
$user = 'root'; 
$pass = ''; 
$db = 'test';
$connection = new mysqli('localhost', $user, $pass, $db) or die("Unable to connect");

if(!$rresult = $connection->query("SELECT I.upc, I.category, I.price, SUM(P.quantity) AS rsold, O.date
FROM Item I, Purchase_Item P, Orders O
WHERE O.date = $dadate AND I.upc = P.upc AND P.receiptId = O.receiptId
GROUP BY I.title, I.company, O.date
ORDER BY I.category, rsold")){
  echo "this query did not work1!!";
  die('There was an error running the report query');
}
/*
$rrow = $rresult->fetch_assoc();
echo "'.$rrow['category'].'";
$cat = $rrow['category'];*/
$a = 0;
$b = 0;
while($rrow = $rresult->fetch_assoc()){
  if($a=$b){
    $cat = $rrow['category'];
    $b++;
  }
  if($cat == $rrow['category']){
    $rprice = $rrow['price'];
    $rquantity = $rrow['rsold'];
    $totalIVal = $rquantity * $rprice;
    $cVal += $totalIVal;
    $tValue += $totalIVal;
    echo "<tr><td>".$rrow['upc']."</td>"; 
    echo "<td>".$rrow['category']."</td>";  
    echo "<td>".$rrow['price']."</td>";
    echo "<td>".$rrow['rsold']."</td>";
    echo "<td>".$totalIVal."</td></tr>"; 
  }
  else{
    echo "<tr><td>".$rrow['upc']."</td>"; 
    echo "<td>".$rrow['category']."</td>";  
    echo "<td>".$rrow['price']."</td>";
    echo "<td>".$rrow['rsold']."</td>";
    echo "<td>".$totalIVal."</td></tr>"; 
    echo "<td>".$cVal."</td></tr>";
    $cVal = 0;
  }  
    $cat = $rrow['category'];
}

    echo "<tr><td>".$rrow['upc']."</td>"; 
    echo "<td>".$rrow['category']."</td>";  
    echo "<td>".$rrow['price']."</td>";
    echo "<td>".$rrow['rsold']."</td>";
    echo "<td>".$totalIVal."</td></tr>"; 
    echo "<td>".$cVal."</td></tr>";
    echo "</tbody></table>";
?>
<tbody>
<tr valign=center>
<td class=rowheader>TValue</td>
</tr>
<?php    
    echo "<td>".$tValue."</td></tr>";
    echo "</tbody></table>";
?>

<form method="POST" action="report.php">
<p><input type="submit" value="Back" name="Back"></p>
</form> 
</html>

