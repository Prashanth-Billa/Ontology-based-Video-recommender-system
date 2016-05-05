<?php
session_start();
include "connect.php";
if(!$_SESSION["user_name"]) {
	header("Location:index.php");
}
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
<html>
<head>
<title>User Login</title>
<link rel="stylesheet" type="text/css" href="styles.css" />
</head>
<body>
<div style="background-color:black;color:white;height:50px;width:1200px;float:left;">
<div align="center">
<br>
<b>Semantic Recommendation system using structured Ontology</b>
</div>
</div>
<div id="content" style="background-color:#F3E5AB;height:540px;width:300px;float:left;">
<form enctype="multipart/form-data" action="" method="POST">
   <div align="center"><font size='3px' color='#39F'> Upload/Change Profile pic</font></div>
    <input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
    <input name="userfile" type="file" />
    <input type="submit" name="sendimage" value="Upload" />
	<hr>
</form>

<?php
if(isset($_POST["sendimage"]))
{
$uploadDir = 'profileimages/'; //Image Upload Folder
$fileName = $_FILES['userfile']['name'];
$tmpName  = $_FILES['userfile']['tmp_name'];
$fileSize = $_FILES['userfile']['size'];
$fileType = $_FILES['userfile']['type'];
$filePath = $uploadDir . $fileName;
$result = move_uploaded_file($tmpName, $filePath);
if (!$result) {
echo "Error uploading file";
exit;
}
$username = $_SESSION["user_name"];
if(!get_magic_quotes_gpc())
{
    $fileName = addslashes($fileName);
	$filePath = addslashes($filePath);
}
$qpic = "update users set profilepic = '$filePath' where user_name = '$username'";
mysql_query($qpic) or die('Error, query failed');
header("location:dashboard.php");
}
?>
<b><div align="center"> Recently completed lectures: </div></b><br>
<?php
$username = $_SESSION["user_name"];
$a =mysql_query("select * from userlearnt where user_name='$username' order by likeid desc limit 3");
while($b = mysql_fetch_array($a))
{
	$v = $b["videoid"];
	$vq = mysql_query("select * from learntvideos where id='$v'");
	$fetch = mysql_fetch_array($vq);
	$in = $fetch["name"];
	$sq = mysql_query("select class, url from instanceclass where instance = '$in'");
	$sqq = mysql_fetch_array($sq);
	echo "<a    target='_blank' href='resultmain.php?instance=".$in."&class=".$sqq["class"]."&url=".$sqq["url"]."'><img src='thumbnails/".youtubeID($sqq["url"]).".jpg'/><br>".$in."</a>";
	echo "<hr>";
}
$h2 = mysql_query("select * from learntvideos, userlearnt where learntvideos.id = userlearnt.videoid and userlearnt.user_name='$username'");
$count_number = mysql_num_rows($h2);
echo "<b> Total lectures completed :".$count_number."</b>";

?>
</div>
<div id="content" style="height:547px;width:600px;float:left;">
<table border="0" cellpadding="10" cellspacing="1" width="500" align="center">
<tr class="tableheader">
<td align="center">User Dashboard</td>
</tr>
<tr class="tableheader">
<td align="center"><span style="font-size:13px" id="datetime"> </span></td>
</tr>
<tr class="tablerow">
<td>
<?php
if($_SESSION["user_name"]) {
?>
<?php
$username = $_SESSION["user_name"];
$qshow = "SELECT * FROM users WHERE user_name = '$username'";
$rshow = mysql_query($qshow) or die(mysql_error());
	while($rowshow = mysql_fetch_array($rshow))
	{
	$path = $rowshow["profilepic"];
echo "<img src='$path' height='90px'/>";
}
?>Welcome <b><?php echo $_SESSION["user_name"]; ?>.</b> Click here to <a href="logout.php" tite="Logout">Logout.
<?php
}
?>
<br>
</td>
</tr>
<tr>
<td>
<a href="search.php"><img src="images/s.png"/>Search</a>
<br><br>
<a href="usermain.php"><img src="images/check.jpg" width="30px"/>Start learning</a>
<br><br>
<a href="user.php"><img src="images/users.jpg" width="30px"/>Follow user topics </a><br><br>
<a href="history.php"><img src="images/history.jpg" width="40px"/>Video topics already seen</a>
<br><br><br>
</td>
</tr>
</table>
</div>
<div id="content" style="background-color:#F3E5AB;height:530px;width:300px;float:left;">
<b><div align="center">Currently following :<br><sub>(Ordered By user Similarity)</div></b> <br><br>
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
$user = $_SESSION["user_name"];
$cur_f = mysql_query("select * from following where name1='$user'");
$userper = array();
while($r = mysql_fetch_array($cur_f))
{
	$t = $r['name2'];
	$show_per = cal_match($t);
	$show_per = round($show_per, 2);
	$userper[$t] = $show_per;
}
arsort($userper);
foreach($userper as $key=>$value)
{
		echo "<a href='usermatch.php?name=".$key."'><img src='images/user.jpg' width='50px'/><b>".$key."</b></a><br>";
}
?>
</div>
<br>
<script>
var d = new Date(),
    minutes = d.getMinutes().toString().length == 1 ? '0'+d.getMinutes() : d.getMinutes(),
    hours = d.getHours().toString().length == 1 ? '0'+d.getHours() : d.getHours(),
    ampm = d.getHours() >= 12 ? 'pm' : 'am',
    months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
    days = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];

document.getElementById("datetime").innerHTML = days[d.getDay()]+' '+months[d.getMonth()]+' '+d.getDate()+' '+d.getFullYear()+' '+hours+':'+minutes+ampm;
</script>
</body></html>
