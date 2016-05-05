<?php
session_start();
include "connect.php";
$uid = $_SESSION["user_id"];
$name = $_GET["concept"];
$cq = mysql_query("select * from concepts where conceptname = '$name'");
$cnum = mysql_fetch_array($cq);
$cid = $cnum["conceptid"];
if($_GET["type"] == "follow")
{
$q = mysql_query("insert into userconcept VALUES ('$uid', '$cid')");
}
else
{
$q = mysql_query("delete from userconcept where uid='$uid' and cid = '$cid'");
}

?>