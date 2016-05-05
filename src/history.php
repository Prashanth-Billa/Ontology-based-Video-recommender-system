<?php
session_start();
$username = $_SESSION["user_name"];
$email = $_SESSION["user_email"];
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<input type="button" value="back" onclick="history.go(-1)"/><br>
<div align="center">
<img src="images/seen.jpg" width="90px"/>
</div>
<header class="header" align="center">
<h3 align="center">Videos Seen</h3>
</header>
<br>
<?php
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
include "connect.php";
$h = mysql_query("select learntvideos.name from learntvideos, userlearnt where learntvideos.id = userlearnt.videoid and userlearnt.user_name='$username'");
while($ret = mysql_fetch_row($h))
{
	
	//echo "<br> URL : ".$ret["url"];
	$in = $ret[0];
	$sq = mysql_query("select class, url from instanceclass where instance = '$in'");
	$sqq = mysql_fetch_array($sq);
	echo "<a    target='_blank' href='resultmain.php?instance=".$in."&class=".$sqq["class"]."&url=".$sqq["url"]."'><img src='thumbnails/".youtubeID($sqq["url"]).".jpg'/><br>".$in."</a>";
	echo "<hr>";
}
?>
</body>
</html>