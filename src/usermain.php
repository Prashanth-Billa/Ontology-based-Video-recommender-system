<html>
<?php
include "connect.php";
session_start();
?>
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
function getindividuals($name)
{
	require_once( "sparqllib.php" );
 $retarray = array();
$db = sparql_connect( "http://localhost:3030/dataset/query" );
if( !$db ) { print sparql_errno() . ": " . sparql_error(). "\n"; exit; }
sparql_ns("ns", "http://www.semanticweb.org/amrit/ontologies/2014/2/untitled-ontology-8#");
sparql_ns("rdf", "http://www.w3.org/1999/02/22-rdf-syntax-ns#");
sparql_ns("owl", "http://www.w3.org/2002/07/owl#");
sparql_ns("rdfs", "http://www.w3.org/2000/01/rdf-schema#");
sparql_ns("xsd", "http://www.w3.org/2001/XMLSchema#");

$sparql = "SELECT ?instance  WHERE {
   ?class rdfs:subClassOf* ns:".$name." . 
   ?instance rdf:type ?class .
}";
$result = sparql_query( $sparql ); 
if( !$result ) { print sparql_errno() . ": " . sparql_error(). "\n"; exit; }
 $flag = 0;
$fields = sparql_field_array( $result );
//print "<p>Number of rows: ".sparql_num_rows( $result )." results.</p>";
while( $row = sparql_fetch_array( $result ) )
{

	$show = "";
	foreach( $fields as $field )
	{
		$show = explode("#", $row[$field]);
		array_push($retarray, $show[1]);
		}
	}
		return $retarray;
}

function geturl($name)
{
	$url = "";
	require_once( "sparqllib.php" );
 $retarray = array();
$db = sparql_connect( "http://localhost:3030/dataset/query" );
if( !$db ) { print sparql_errno() . ": " . sparql_error(). "\n"; exit; }
sparql_ns("ns", "http://www.semanticweb.org/amrit/ontologies/2014/2/untitled-ontology-8#");
sparql_ns("rdf", "http://www.w3.org/1999/02/22-rdf-syntax-ns#");
sparql_ns("owl", "http://www.w3.org/2002/07/owl#");
sparql_ns("rdfs", "http://www.w3.org/2000/01/rdf-schema#");
sparql_ns("xsd", "http://www.w3.org/2001/XMLSchema#");

$sparql = "SELECT ?instance  WHERE {
   ?class rdfs:subClassOf* ns:".$name." . 
   ?instance rdf:type ?class .
}";
$result = sparql_query( $sparql ); 
if( !$result ) { print sparql_errno() . ": " . sparql_error(). "\n"; exit; }
 $flag = 0;
$fields = sparql_field_array( $result );
//print "<p>Number of rows: ".sparql_num_rows( $result )." results.</p>";
while( $row = sparql_fetch_array( $result ) )
{

	$show = "";
	foreach( $fields as $field )
	{
		$show = explode("#", $row[$field]);
		
		//$show[1];
		array_push($retarray, $show[1]);
		$sparql1 = "SELECT ?x
WHERE { 
   ns:".$show[1]." ns:hasURL ?x . 
}";
$result1 = sparql_query( $sparql1 ); 
if( !$result1 ) { print sparql_errno() . ": " . sparql_error(). "\n"; exit; }
$fields1 = sparql_field_array( $result1 );
//print "<p>Number of rows: ".sparql_num_rows( $result )." results.</p>";
while( $row1 = sparql_fetch_array( $result1 ) )
{

	$show1 = "";
	foreach( $fields1 as $field1 )
	{
		//$show1 = explode("#", $row1[$field]);
		
		array_push($retarray, $row1[$field1]);
		
	}
}
		
		
		
	}
}
return $retarray;	
}
?>
<head>
<link rel="stylesheet" href="css/FileTreeView.css" />
	<script type="text/javascript" src="jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="FileTreeView.js"></script>
<link rel="stylesheet" href="style.css" />
<style type="text/css">
#main {
	font-weight: bold;
}
.chk 
{
  display: block;
    float: left;
    width: 100%;
}
.chk li
{
   display:inline-block;
   width:25%;
}
.ccol {
  width: 370px; /* set to whatever width works for you */
  float: left; /* put the columns next to each other */
  margin-right: 10px; /* add some space between columns */
   vertical-align: bottom;
}
</style>
<script>
function fillnumber(val, number)
{
	//alert(val);
	//alert(number);
	document.getElementById(val).innerText = number;
}
function insertconcept(val)
{
location.href="usermain.php";
var follow = "follow";
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById('followconcept'+val).value = "unfollow";
	
    }
  };
xmlhttp.open("GET","conceptchange.php?concept="+val+"&type="+follow);
xmlhttp.send();


 window.location.href = "usermain.php";
}
function deleteconcept(val)
{
location.href="usermain.php";
var follow = "unfollow";
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById('unfollowconcept'+val).value="follow";
    }
  };
xmlhttp.open("GET","conceptchange.php?concept="+val+"&type="+follow);

xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xmlhttp.send();

//location.href = "conceptchange.php?concept="+val+"&type="+follow;
location.href = "usermain.php";
}
	$(function() {
		$('#root_tree').fileTreeView('#expandAll', '#collapseAll', 'folder');
	});
</script>
</head>
<body>
<input type="button" value="Home" onclick="location.href='index.php'"/><br>
<div id="container" style="width:1200px">

<div id="header" class="header">
<h1 style="margin-bottom:0;">On your way to a great learning experience</h1></div>

<div id="content" style="background-color:#EEEEEE;height:1400px;width:800px;float:left;">
  <div id="main" align="center">
    Name :
  <?php echo $_SESSION["user_name"] ?><br /><br>
	Email :
  <?php echo $_SESSION["user_email"] ?>
   
   <br>
   
    </div>
	<div>
	 <p>Explore topics: </p>
<a href="#" id="expandAll">Expand All</a> | <a href="#" id="collapseAll">Collapse All</a><br/>
<ul id="root_tree">
<?php

$starttime = microtime(true);
require_once( "sparqllib.php" );
 
$db = sparql_connect( "http://localhost:3030/dataset/query" );
if( !$db ) { print sparql_errno() . ": " . sparql_error(). "\n"; exit; }
sparql_ns("ns", "http://www.semanticweb.org/amrit/ontologies/2014/2/untitled-ontology-8#");
sparql_ns("rdf", "http://www.w3.org/1999/02/22-rdf-syntax-ns#");
sparql_ns("owl", "http://www.w3.org/2002/07/owl#");
sparql_ns("rdfs", "http://www.w3.org/2000/01/rdf-schema#");
sparql_ns("xsd", "http://www.w3.org/2001/XMLSchema#");
$sparql = "SELECT ?subClass WHERE { ?subClass rdfs:subClassOf  ns:Concept  }";
$result = sparql_query( $sparql ); 
if( !$result ) { print sparql_errno() . ": " . sparql_error(). "\n"; exit; }
 $flag = 0;
$fields = sparql_field_array( $result );
//print "<p>Number of rows: ".sparql_num_rows( $result )." results.</p>";
while( $row = sparql_fetch_array( $result ) )
{

	$show = "";
	foreach( $fields as $field )
	{
		$show = explode("#", $row[$field]);
		//print "<td>$show[1]</td>";
	
		$sparql1 = "SELECT ?subClass WHERE { ?subClass rdfs:subClassOf  ns:".$show[1]." }";
$result1 = sparql_query( $sparql1 ); 
if( !$result1 ) { print sparql_errno() . ": " . sparql_error(). "\n"; exit; }
 $flag1 = 0;
$fields1 = sparql_field_array( $result1 );
//print "<p>Number of rows: ".sparql_num_rows( $result )." results.</p>";
if(sparql_num_rows( $result1 ) <= 0)
{
$urlvalue = geturl($show[1]);
	echo "<li><a target='_blank' href='resultmain.php?instance=".$urlvalue[0]."&class=".$show[1]."&url=".$urlvalue[1]."'><strong>".$show[1]." </strong></a></li>";
}
else
{
	echo "<li><a href='#'><strong>".$show[1]."</strong></a> (<b><span id='".$show[1]."'></b>)</span>";
	$num_c = 0;
	//follow feature
	$uidnow = $_SESSION["user_id"];
	$cq = mysql_query("select conceptid from concepts where conceptname = '$show[1]'");
	$cnum = mysql_fetch_array($cq);
	$cid = $cnum["conceptid"];
	$fq = mysql_query("select * from userconcept where uid = '$uidnow' and cid = '$cid'");
	$fnum = mysql_num_rows($fq);
	if($fnum <= 0)
	{
		
		echo "<input type='button' style='color:green' onclick = insertconcept('$show[1]') id='followconcept".$show[1]."' value = 'follow' />";
	}
	else if($fnum > 0)
	{
		
		echo "<input type='button' style='color:#737CA1' onclick = deleteconcept('$show[1]') id='unfollowconcept".$show[1]."' value='unfollow'/>";
	}
	//
	
	
while( $row1 = sparql_fetch_array( $result1 ) )
{

	$show1 = "";
	foreach( $fields1 as $field1 )
	{
	
		$show1 = explode("#", $row1[$field1]);
		$urlvalue = geturl($show1[1]);
		$indarray = getindividuals($show1[1]);
		
		foreach($indarray as $a1)
		{
			echo "<ol><li><a target='_blank' href='resultmain.php?instance=".$a1."&class=".$show1[1]."&url=".$urlvalue[1]."'><strong>".$show1[1]."</strong></a></ol>";
			$num_c = $num_c + 1;
		}
		
		
		
	}
	
}
echo "</li>";
$cv1 = $num_c;
echo "<script>";
echo "fillnumber('".$show[1]."', ".$cv1.")";
echo "</script>";
$num_c = 0;
}
		
	
	}
	
}


?>
	
	
	
	
	
	
	
	</ul>
</div></div>
<div id="menu" style="background-color:#F3E5AB;height:1400px;width:400px;float:left;overflow:scroll">
<b><div align="center">Recommended Videos</div></b><br><br>
<?php
$followarray = array();
$user = $_SESSION["user_name"];
$allfollow = mysql_query("select * from following where name1='$user'");
while($allresult = mysql_fetch_array($allfollow))
{
$followname = $allresult["name2"];
$q1 = mysql_query("select learntvideos.id, learntvideos.name, learntvideos.url from learntvideos,userlearnt where userlearnt.user_name='$followname' and learntvideos.id = userlearnt.videoid");
while($qresult = mysql_fetch_array($q1))
{
	array_push($followarray, $qresult["id"]);
}
}
$uniquearray = array_unique($followarray);
$total_count = count($uniquearray);
$curarray = array();
$cur_q = mysql_query("select DISTINCT(likeid), videoid from userlearnt where user_name = '$user'");
while($cur_r = mysql_fetch_array($cur_q))
{
	array_push($curarray, $cur_r["videoid"]);
}
$ucur = array_unique($curarray);
$ucount = count($ucur);
$diffarray = array_diff($uniquearray, $ucur);
$uidval = $_SESSION["user_id"];
$iquery = mysql_query("select cid from userconcept where uid='$uidval'");
$interested = array();
$cg1 = array();
$cg2 = array();
while($ifetchv = mysql_fetch_array($iquery))
{

	$need = $ifetchv["cid"];
	$conq = mysql_query("select conceptname from concepts where conceptid=$need");
	$conqq = mysql_fetch_array($conq);
	$fvalue = $conqq["conceptname"];
	
	foreach($curarray as $j)
	{
		$rget = mysql_query("select name from userlearnt, learntvideos where learntvideos.id=userlearnt.videoid and userlearnt.videoid = '$j'");
		$rrget = mysql_fetch_array($rget);
		//array_push($cg2, $rrget["name"]);
	}
	foreach(getindividuals($fvalue) as $push)
	{
		array_push($cg1, $push);
	}
	
	
}
$cg1 = array_diff($cg1, $cg2);
echo "<br>";
$diffarray = array_unique(array_merge($interested, $diffarray));
$dp = array();
foreach($diffarray as $video_id)
{
	$newq = mysql_query("select name, url, class from learntvideos where id=$video_id");
	$newresult = mysql_fetch_array($newq);
	$url = geturl($newresult["class"]);
	array_push($cg1, $newresult["name"]);
	$dp = array_unique($cg1);

	}
foreach($dp as $d)
{
	
	$newq1 = mysql_query("select url, class from instanceclass where instance='$d'");
	$newq2 = mysql_fetch_array($newq1);
	$cval = $newq2["class"];
	$uvalue = $newq2["url"];
	echo "<div style='margin-left:40px'>";
	echo "<a    target='_blank' href='resultmain.php?instance=".$d."&class=".$cval."&url=".$uvalue."'><img src='thumbnails/".youtubeID($uvalue).".jpg'/><br>".$d."</a><hr>";
	echo "</div>";

}
	

$endtime = microtime(true) - $starttime;
//echo round($endtime, 4);
?>

</div>




</div>

</body>
</html>