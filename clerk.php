<html>
<head>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">
<title>Clerk</title>

<body>Item return</body>

<p>Enter information for returned item</p>
<form method="POST" action="clerk.php">
<table border=0 cellpadding=0 cellspacing=0>
<tr><td>returnId</td><td><input type="text" size=20 name="new_retid"</td></tr>
<tr><td>Date</td><td><input type="text" size=20 name="new_date"</td></tr>
<tr><td>receiptId</td><td><input type="text" size=20 name="receiptId"</td></tr>
<tr><td>Item upc</td><td><input type="text" size=20 name="upc"</td></tr>
<tr><td>Quantity</td><td><input type="text" size=20 name="new_quantity"</td></tr>
<tr><td></td><td><input type="submit" name="return" value="Return"></td></tr>
</table>
</form>
<form method="POST" action="home.php">
<input type="submit" name="home" value="home">
</form>
