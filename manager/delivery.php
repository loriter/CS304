<html>
<head>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">
<title>DELIVERY DATE PEW PEW</title>

<body>Set delivery date</body>

<p>Update the delivery date of an order</p>
<form method="POST" action="../manager.php">
<table border=0 cellpadding=0 cellspacing=0>
<tr><td>receiptID</td><td><input type="text" size=20 name="receiptID"</td></tr>
<tr><td>DeliveryDate</td><td><input type="text" size=20 name="new_DeliveryDate"</td></tr>
<tr><td></td><td><input type="submit" name="delivery" value="SetDelivery"></td></tr>
</table>
</form>

<form method="POST" action="../manager.php">
<p><input type="submit" value="Manager" name="manager"></p>
</form>
</body>
</html>