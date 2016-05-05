<html>
<head>
<link rel="stylesheet" href="style.css" />
</head>
<body>
<input type="button" value="back" onclick="history.go(-1)"/><br>
<div align="center">
<img src="images/follow.jpg" width="80px"/>
</div>
<div align="center" class="header">
<h2> Follow Users and their Topics </h2>
<br> Ordered by user similarity<br>
</div>
<br>
</body>
<?php
function cal_match($username)
{
	$cur_learnt = array();
$follow_learnt = array();
$curname = $_SESSION["user_name"];
$que1 = mysql_query("select * from userlearnt where user_name = '$curname'");
$rque1 = mysql_num_rows($que1);
$que2 = mysql_query("select * from userlearnt where user_name='$username'");
$rque2 = mysql_num_rows($que2);
while($fetch1 = mysql_fetch_array($que1))
{
	array_push($cur_learnt, $fetch1["videoid"]);
	
}
while($fetch2 = mysql_fetch_array($que2))
{
	array_push($follow_learnt, $fetch2["videoid"]);

}
$newarr = array_unique(array_merge($cur_learnt, $follow_learnt));
$intersect = array_intersect($cur_learnt, $follow_learnt);
$diff = array_diff($newarr, $cur_learnt);
$diff_number = count($diff);
$total = count($newarr);
$intersect_number = count($intersect);
$percentage = 0;
$percentage = ($intersect_number/$total)*100;
return $percentage;
}
session_start();
include "connect.php";
$rid = $_SESSION["user_id"];
$thisp = $_SESSION["user_name"];
$rflag = 0;
$mysqlquery = mysql_query("select * from users where user_id!=$rid") or die(mysql_error());
$userper = array();
while($r = mysql_fetch_array($mysqlquery))
{
	$ch1 = mysql_query("select * from following where name1='$thisp'");
	$t = $r['user_name'];
while($ch1r = mysql_fetch_array($ch1))
{
	
	if($ch1r["name2"] == $t)
	{
	$rflag = 1;
	
	}
}
if($rflag == 0)
{
$show_per = cal_match($t);
	$show_per = round($show_per, 2);
	$userper[$t] = $show_per;
}
$rflag = 0;
}
arsort($userper);


echo "<div align='center'>";
foreach($userper as $key=>$value)
{
echo "<br>";
		echo "<a href='usermatch.php?name=".$key."'>";
		
		$qshow = "SELECT * FROM users WHERE user_name = '$key' and profilepic != '' ";
$rshow = mysql_query($qshow) or die(mysql_error());
$rshown = mysql_num_rows($rshow);
if($rshown > 0)
{
	while($rowshow = mysql_fetch_array($rshow))
	{
	$path = $rowshow["profilepic"];
echo "<img src='$path' width='80px'/>";
}
}
else
{
echo "<img src='images/user.jpg' width='80px'/>";
}
		echo "<br>";
		echo "<b>".$key."</b></a><br>";
		echo "<hr width='290px'>";
}
echo "<br>";
?>
</div>
</html>