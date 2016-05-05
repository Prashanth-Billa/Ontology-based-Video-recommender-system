<?php
session_start();
$conn = mysql_connect("localhost","root","root");
mysql_select_db("fyp",$conn);
$username = mysql_real_escape_string($_POST["username"]);
$useremail = mysql_real_escape_string($_POST["emailaddress"]);
$p1 = mysql_real_escape_string($_POST["userpassword"]);
$p2 = mysql_real_escape_string($_POST["usercpassword"]);
if($p1 != $p2)
{
	echo "<font color='red'>Passwords donot match</font>";
	header('Refresh: 2; url=index.php');
}
else if($p1 == $p2)
{
	if(mysql_query("INSERT INTO users(user_name, user_email, password) VALUES('$username', '$useremail', '$p1')"))
	{
	$result = mysql_query("SELECT * FROM users WHERE user_name='" . $username . "' and password = '". $p1."'");
		$row  = mysql_fetch_array($result);
		if(is_array($row)) {
			$_SESSION["user_id"] = $row["user_id"];
			$_SESSION["user_name"] = $row["user_name"];
			$_SESSION["user_email"] = $row["user_email"];
			}
	echo "<font color='green'>Successfull registered</font>";
	header('Refresh: 2; url=dashboard.php');
	}
	else
	{
		echo "<font color='green'>Not Successfull :( Try again </font>";
		header('Refresh: 3; url=index.php');
	}
}

?>