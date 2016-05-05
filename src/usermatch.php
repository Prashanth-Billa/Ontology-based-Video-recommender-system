<html>
<?php
session_start();
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
include "connect.php";
$username = $_GET["name"];
function youtubeID($string) {
    $pattern = 
        '%^# Match any youtube URL
        (?:https?://)?  
        (?:www\.)?      
        (?:             
          youtu\.be/    
        | youtube\.com  
          (?:           
            /embed/     
          | /v/         
          | /watch\?v=  
          )             
        )               
        ([\w-]{10,12})  
        $%x'
        ;
    $result = preg_match($pattern, $string, $matches);
    if (false !== $result) {
        return $matches[1];
    }
    return false;
}
?>
<head>
<link rel="stylesheet" href="style.css" />
</head>
<body>
<input type="button" value="Home" onclick="location.href='dashboard.php'"/><br>
<div align="center" class="header">
<div align="center">
<?php
$qshow = "SELECT * FROM users WHERE user_name = '$username' and profilepic != '' ";
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
echo "<img src='images/u.jpg' width='80px'/>";
}
?>
<br>
<h2> User - <?php echo "<b>".$username."</b>" ?> </h2>
</div>

<div align="center">
<div style="background-color:#EBDDE2;height:186px;width:1250px;float:left;">
<?php
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

if($percentage >= 80)
{
	echo "<br> Your Interest match upto :<font color='green'><b>".round($percentage,2). "% </b></font>";
}
else if($percentage >= 40 && $percentage < 80)
{
	echo "<br> Your Interest match upto : <font color='purple'><b>".round($percentage,2). "% </b></font>";
}
else if($percentage < 40 && $percentage >= 0)
{
	echo "<br> Your Interest match upto : <font color='blue'><b>".round($percentage,2). "% </b></font>";
}
echo "<br>";
echo "No of matching videos :<b> ".$intersect_number." </b>";;
?>
<br><br>
<form name="follow" method="post" action="">
<input type="hidden" value="<?php echo $username; ?>" name="followname"/>
<?php
include "connect.php";
$a = $_SESSION["user_name"];
$b = mysql_query("select * from following where name1='$a' and name2='$username'");
$c = mysql_num_rows($b);
if($c == 0)
{
	echo "<img src='images/up.png' width='60px'/><br><input type='submit' name='submithere' value='Follow'/>";
}
else
{
	echo "<img src='images/low.png' width='60px'><br><input type='submit' name='unfollow' value='unfollow'/>";
}
?>
</form>
</div>
<div style="background-color:#F3E5AB;height:566px;width:350px;float:left;overflow:scroll">
<b><font color='black'><?php echo $username; ?> 's Learnt Videos : </font></b><br><br>
<?php
$h = mysql_query("select learntvideos.name from learntvideos, userlearnt where learntvideos.id = userlearnt.videoid and userlearnt.user_name='$username'");
while($ret = mysql_fetch_row($h))
{
	$in = $ret[0];
	$sq = mysql_query("select class, url from instanceclass where instance = '$in'");
	$sqq = mysql_fetch_array($sq);
	echo "<a    target='_blank' href='resultmain.php?instance=".$in."&class=".$sqq["class"]."&url=".$sqq["url"]."'><img src='thumbnails/".youtubeID($sqq["url"]).".jpg'/><br>".$in."</a>";
	echo "<hr>";
}
?>
</div>

<div style="height:550px;width:566px;float:left;overflow:scroll">
<b><font color='black'>New Videos you will be learning if you follow <?php echo $username; ?> : <?php echo $diff_number." videos"; ?></font></b><br><br>
<?php
foreach($diff as $ele)
{
	
	$diffquery = mysql_query("select learntvideos.name from learntvideos, userlearnt where learntvideos.id = userlearnt.videoid  and userlearnt.videoid='$ele'");
	$res_set = mysql_fetch_array($diffquery);
	$in = $res_set['name'];
	$sq = mysql_query("select class, url from instanceclass where instance = '$in'");
	$sqq = mysql_fetch_array($sq);
	echo "<a    target='_blank' href='resultmain.php?instance=".$in."&class=".$sqq["class"]."&url=".$sqq["url"]."'><img src='thumbnails/".youtubeID($sqq["url"]).".jpg'/><br>".$in."</a>";
	echo "<hr>";
	//echo "URL : ".$res_set['url']."<br>";
}
?>

</div>
<div style="background-color:#F3E5AB;height:566px;width:280px;float:left;overflow:scroll">
<b><font color='black'>Users <?php echo $username; ?> is following :</b><br>
<sub>Ordered by your similarity with them</font></sub>
<br>
<?php
$userper = array();
$seluser = mysql_query("select * from following where name1='$username' and name2!='$curname'");

while($sval = mysql_fetch_array($seluser))
{
echo "<br>";
$person = $sval["name2"];
$per = cal_match($sval["name2"]);
$per = round($per, 2);
$t2 = $sval["name2"];
$userper[$t2] = $per;
	
}
arsort($userper);
foreach($userper as $key=>$value)
{
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
echo "<img src='images/u.jpg' width='80px'/>";
}
	echo "<br><a href='usermatch.php?name=".$key."'>".$key."</a>";
	echo "<br>";
	echo "<br>";
}	
echo "<br>";

?>
</div>
<?php

if(isset($_POST["submithere"]))
{
$followname = $username;
include "connect.php";
$cur_name = $_SESSION["user_name"];
$q = mysql_query("select * from following where name1=$cur_name and name2=$followname");
$n = mysql_num_rows($q);
if($n <= 0)
{
	$query = mysql_query("insert into following VALUES('$cur_name', '$followname')") or die(mysql_error());
	if($query)
	{
	echo "<font color='green'> Successfully followed ".$followname."</font>";
	header("refresh:1;url=user.php");
	}
	else
	{
		echo "<font color='red'> Failed </font>";
		header("refresh:1;url=user.php");
	}
	
}

}
if(isset($_POST["unfollow"]))
{
$followname = $username;
include "connect.php";
$cur_name = $_SESSION["user_name"];
		$del = "delete from following where name1='$cur_name' and name2='$followname'";
		$rdel = mysql_query($del);
		if($rdel)
	{
	echo "<font color='green'> Successfully unfollowed ".$followname."</font>";
	header("refresh:1;url=user.php");
	}
	else
	{
		echo "<font color='red'> Failed </font>";
		header("refresh:1;url=user.php");
	}
}

?>
</div>
</body>
</html>