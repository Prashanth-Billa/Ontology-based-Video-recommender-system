<?php
session_start();
$message="";
if(count($_POST)>0) {
$conn = mysql_connect("localhost","root","root");
mysql_select_db("fyp",$conn);
$result = mysql_query("SELECT * FROM users WHERE user_name='" . $_POST["user_name"] . "' and password = '". $_POST["password"]."'");
$row  = mysql_fetch_array($result);
if(is_array($row)) {
$_SESSION["user_id"] = $row[user_id];
$_SESSION["user_name"] = $row[user_name];
$_SESSION["user_email"] = $row[user_email];
} else {
$message = "Invalid Username or Password!";
}
}
if(isset($_SESSION["user_id"])) {
header("Location:dashboard.php");
}
?>
<html>
<head>
<title>User Login</title>
<link rel="stylesheet" type="text/css" href="styles.css" />
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<header align="center">
<h3 align="center" class="header">
        Semantic Recommender using Ontology Project - Login
        </h3>
</header>
<div id="content" style="height:547px;width:600px;float:left;">
<div align="center">
<br><img src="images/lock.jpg"/><br> Login 
</div>
<form name="frmUser" action="" method="post" id="loginf">
<div class="message"><?php if($message!="") { echo $message; } ?></div>
Username : <input type="text" id="username" name="user_name">
Password : 		<input type="password" id="password" name="password">				
		<button type="submit" class="loginbutton">Login</button>	
		
	</form>
</div>
<div id="menu" style="height:546px;width:20px;float:left;">
<br><br><br><br><br><br><br><br>
</div>
<div id="register" style="background-color:#F3E5AB;height:546px;width:580px;float:left;">
<div align="center"><br><br>Register </div>
<form id="signup" action="register.php" method="post">
	Email Address:	<input type="email" placeholder="Your email address" required="yes" name="emailaddress">
		Username :<input type="text" placeholder="Your name" required="yes" name="username">
		Password :<input type="password" placeholder="Your password" required="yes" name="userpassword">
		Confirm Password :<input type="password" placeholder="Confirm password" required="yes" name="usercpassword">					
		<button type="submit" class=" loginbutton">Register now</button>	
	</form>
</div>
</body></html>