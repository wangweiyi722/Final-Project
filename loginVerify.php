<html>
<head>
<title>Login Verification</title>
</head>
<body>
<?php
  $logged = false;
  extract($_POST);
 $username = trim($_POST['user']);
 $password = trim($_POST['password']);

  // Connect to the MySQL database
$host = "spring-2018.cs.utexas.edu";
$user = "weiyi";
$pwd = "A2LQHs~cPZ";
$dbs = "cs329e_weiyi";
$port = "3306";

$connect = mysqli_connect ($host, $user, $pwd, $dbs, $port);

if (empty($connect))
{
  die("mysqli_connect failed: " . mysqli_connect_error());
}

$qry  =  "SELECT user_id, password FROM users WHERE user_id=?";
$stmt = mysqli_prepare ($connect, $qry);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
//$result = mysqli_stmt_store_result($qryt);

if(mysqli_stmt_num_rows($stmt) === 1){
	$result = mysqli_query($connect, "SELECT * FROM users WHERE user_id='$username'");	
	$row = $result->fetch_row();
	if($password === $row[1]){
		if($row[6] === '1'){
			$fname = $row[2];
               		session_start();
			$_SESSION["admin"] = $username;
			setcookie("usertype", "admin", time()+600);
			header("location: adminhome.php ");
		}
		else{	
			$fname = $row[2];
			session_start();
			$_SESSION["user"] = $username;
			setcookie("usertype", "user", time()+600);
			header("location: userhome.php ");
		}
	}
	else{
		echo "<h2>Wrong username or password. Please try again.</h2>";
	
	}			
}
else{
	echo "<h2>Wrong username or password. Please try again.</h2>";

}

?>

</body>
</html>

