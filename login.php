<html>
<head>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">
<title>Customer Login</title>

<body>Customer Login or Registration</body>

<?php

	$connection = new mysqli("dbserver.ugrad.cs.ubc.ca", "j4n8", "a29454113", "j4n8");

    // Check that the connection was successful, otherwise exit
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		if(isset($_POST["login"]) && $_POST["login"] == "LOGIN") {
			
			$cid = $_POST["username"];
			$pass = $_POST["password"];
			
			echo $cid;
			echo $pass;
			
			//Query needs to be changed to check for same username and password
			$qry = "SELECT cid, password FROM customer WHERE cid = '".$cid."' AND password = '".$pass."'";
			
			if (!$result = $connection->query($qry)) {
				die('There was an error running the query [' . $db->error . ']');
			}
			if( $result->num_rows > 0){
				header('Location: customer.php');
				exit;
			}
			else {
				echo "<p><b>Login Failed </b></p>";
			}
		}
		
		else if(isset($_POST["register"]) && $_POST["register"] == "Register") {
			
			$cid = $_POST["new_cid"];
			$pass = $_POST["new_pass"];
			$name = $_POST["new_name"];
			$add = $_POST["new_add"];
			$phone = $_POST["new_phone"];
			
			$stmt = $connection->prepare("INSERT INTO customer (cid, password, name, address, phoneno) VALUES (?,?,?,?,?)");
			//$stmt = oci_parse($connection, "INSERT INTO customer (cid, password, name, address, phoneno) VALUES (:cid, :password, :name, :address, :phoneno)");
			
			$stmt->bind_param("sssss", $cid, $pass, $name, $add, $phone);
			
			$stmt->execute();
			
			if($stmt->error) {
				printf("<p><b>Error: %s.</p></b>\n", $stmt->error);
			}
			else {
				echo "<p><b>Successfully registered </b></p>";
			}
		}
		else{
			echo "<p>Click Register if you do not have an account</p>";
		}
	}
	
	else{
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

<p>Back to Home</p>
<form method="POST" action="home.php">
<p><input type="submit" value="Home" name="home"></p>
</form>

</body>
</html>