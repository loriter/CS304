<html>
<head>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">
<title>Customer Login</title>

<body>Customer Login or Registration</body>

<?php

	/* MYSQL CONNECTION CODE
	$connection = new mysqli("dbserver.ugrad.cs.ubc.ca", "j4n8", "s29454113", "j4n8");

    // Check that the connection was successful, otherwise exit
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }*/
	
	$connection = OCILogon("ora_j4n8", "a29454113", "ug");
    // Check that the connection was successful, otherwise exit
    if (!$connection) {
        echo "<p> Connect failed:\n </p>";
        exit();
    }
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		if(isset($_POST["login"]) && $_POST["login"] == "LOGIN") {
			
			$cid = $_POST["username"];
			$pass = $_POST["password"];
			
			//Query needs to be changed to check for same username and password
			$qry = "SELECT cid, password FROM customer";
			
			$result = oci_parse($connection, $qry);
			if( $result->num_rows > 0){
				header('Location: customer.php');
				exit;
			}
			else {
				echo "<p><b>Login Failed </b></p>";
			}
		}
		
		if(isset($_POST["register"]) && $_POST["register"] == "Register") {
			
			$cid = $_POST["new_cid"];
			$pass = $_POST["new_pass"];
			$name = $_POST["new_name"];
			$add = $_POST["new_add"];
			$phone = $_POST["new_phone"];
			
			//$stmt = $connection->prepare("INSERT INTO customer (cid, password, name, address, phoneno) VALUES (?,?,?,?,?)");
			$stmt = oci_parse($connection, "INSERT INTO customer (cid, password, name, address, phoneno) VALUES (:cid, :password, :name, :address, :phoneno)");
			
			//$stmt->bind_param("sss", $cid, $pass, $name, $add, $phone);
			oci_bind_by_name($stmt, ':cid', $cid);
			oci_bind_by_name($stmt, ':password', $pass);
			oci_bind_by_name($stmt, ':name', $name);
			oci_bind_by_name($stmt, ':address', $add);
			oci_bind_by_name($stmt, ':phoneno', $phone);
			
			//$stmt->execute();
			oci_execute($stmt);
			oci_commit($connection);
			oci_free_statement($stmt);
			
			if($stmt->error) {
				printf("<b>Error: %s.</b>\n", $stmt->error);
			}
			else {
				echo "<p><b>Successfully registered </b></p>";
			}
		}
	}
	else {
		echo "<p>Click Register if you do not have an account</p>";
	}
	?>


<form method="POST" action="login.php">
<table border=0 cellpadding=0 cellspacing=0>
<tr><td>Username</td><td><input type="text" size=20 name="username"</td></tr>
<tr><td>Password</td><td><input type="text" size=20 name="password"</td></tr>
<tr><td></td><td><input type="submit" name="login" value="LOGIN"></td></tr>
</table>
</form>

<form method="POST" action="register.php">
<input type="submit" name="register" value="Register">
</form>
</body>
</html>