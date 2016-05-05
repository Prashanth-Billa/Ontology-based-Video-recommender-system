 <html>
 <head>

<link rel="stylesheet" href="style.css" />
<style type="text/css">
body{
	font-family: "Century Gothic", CenturyGothic, AppleGothic, sans-serif;
}
</style>
<script>

</script>
</head>
<?php
$prereq = array();
$simi = array();
include "connect.php";
session_start();
$result = array();
function getchild($name)
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

$sparql = "SELECT ?subClass WHERE { ?subClass rdfs:subClassOf  ns:".$name." }";
$result = sparql_query( $sparql ); 
if( !$result ) { print sparql_errno() . ": " . sparql_error(). "\n"; exit; }
 $flag = 0;
$fields = sparql_field_array( $result );
//print "<p>Number of rows: ".sparql_num_rows( $result )." results.</p>";
while( $row = sparql_fetch_array( $result ) )
{

	foreach( $fields as $field )
	{
		$show = explode("#", $row[$field]);
		array_push($retarray, $show[1]);
		}
	}
		return $retarray;	
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
function getparent($name)
{
	$ret = array();
	require_once( "sparqllib.php" );
$db = sparql_connect( "http://localhost:3030/dataset/query" );
if( !$db ) { print sparql_errno() . ": " . sparql_error(). "\n"; exit; }
sparql_ns("ns", "http://www.semanticweb.org/amrit/ontologies/2014/2/untitled-ontology-8#");
sparql_ns("rdf", "http://www.w3.org/1999/02/22-rdf-syntax-ns#");
sparql_ns("owl", "http://www.w3.org/2002/07/owl#");
sparql_ns("rdfs", "http://www.w3.org/2000/01/rdf-schema#");
sparql_ns("xsd", "http://www.w3.org/2001/XMLSchema#");
$sparql = "SELECT ?superClass WHERE { ns:".$name." rdfs:subClassOf ?superClass . }";
$result = sparql_query( $sparql ); 
if( !$result ) { print sparql_errno() . ": " . sparql_error(). "\n"; exit; }
 $flag = 0;
$fields = sparql_field_array( $result );
//print "<p>Number of rows: ".sparql_num_rows( $result )." results.</p>";
while( $row = sparql_fetch_array( $result ) )
{
	foreach( $fields as $field )
	{
		$show = explode("#", $row[$field]);
		//echo "<b>".$show[1]."</b>";
		array_push($ret, $show[1]);
	}
}
return $ret;
}
function haspre($name)
{
		require_once( "sparqllib.php" );
 
$db = sparql_connect( "http://localhost:3030/dataset/query" );
if( !$db ) { print sparql_errno() . ": " . sparql_error(). "\n"; exit; }
sparql_ns("ns", "http://www.semanticweb.org/amrit/ontologies/2014/2/untitled-ontology-8#");
sparql_ns("rdf", "http://www.w3.org/1999/02/22-rdf-syntax-ns#");
sparql_ns("owl", "http://www.w3.org/2002/07/owl#");
sparql_ns("rdfs", "http://www.w3.org/2000/01/rdf-schema#");
sparql_ns("xsd", "http://www.w3.org/2001/XMLSchema#");
$sparql = "SELECT ?o
WHERE
{ 
{ ?s ?p ?o } 

?s owl:onProperty ns:hasRequisite.
ns:".$name." rdfs:subClassOf* ?s.
?o rdfs:subClassOf  ns:Concept .
}       ";
$result = sparql_query( $sparql ); 
if( !$result ) { print sparql_errno() . ": " . sparql_error(). "\n"; exit; }
 $flag = 0;
$fields = sparql_field_array( $result );
if(sparql_num_rows( $result ) > 0)
{
	return 1;
}
else
{
	return 0;
}

}
function getpre($name,$mainclass)
{

global $result;
global $prereq;
if(!haspre($name))
{
	return $result;
}
else
{
	require_once( "sparqllib.php" );

$db = sparql_connect( "http://localhost:3030/dataset/query" );
if( !$db ) { print sparql_errno() . ": " . sparql_error(). "\n"; exit; }
sparql_ns("ns", "http://www.semanticweb.org/amrit/ontologies/2014/2/untitled-ontology-8#");
sparql_ns("rdf", "http://www.w3.org/1999/02/22-rdf-syntax-ns#");
sparql_ns("owl", "http://www.w3.org/2002/07/owl#");
sparql_ns("rdfs", "http://www.w3.org/2000/01/rdf-schema#");
sparql_ns("xsd", "http://www.w3.org/2001/XMLSchema#");
$sparql = "SELECT ?o
WHERE
{ 
{ ?s ?p ?o } 

?s owl:onProperty ns:hasRequisite.
ns:".$name." rdfs:subClassOf* ?s.
?o rdfs:subClassOf  ns:Concept .
}       ";
$result = sparql_query( $sparql ); 
if( !$result ) { print sparql_errno() . ": " . sparql_error(). "\n"; exit; }
 $flag = 0;
$fields = sparql_field_array( $result );
//print "<p>Number of rows: ".sparql_num_rows( $result )." results.</p>";
if(sparql_num_rows( $result ) > 0)
{

while( $row = sparql_fetch_array( $result ) )
{

	foreach($fields as $field)
	{
		$show = explode("#", $row[$field]);
		array_push($result, $show[1]);
			
			$sparql1 = "SELECT ?o
WHERE
{ 
{ ?s ?p ?o } 
?s owl:onProperty ns:isPrerequisiteFor.
ns:".$show[1]." rdfs:subClassOf* ?s.
?o rdfs:subClassOf  ns:Concept .
}   ";
$result1 = sparql_query( $sparql1 ); 
if( !$result1 ) { print sparql_errno() . ": " . sparql_error(). "\n"; exit; }
 $flag1 = 0;
$fields1 = sparql_field_array( $result1 );
if(sparql_num_rows( $result1 ) > 0)
{
	
	while( $row1 = sparql_fetch_array( $result1 ) )
{
	
	foreach($fields1 as $field1)
	{
		
		$show1 = explode("#", $row1[$field1]);
		if(strcmp($show1[1], $mainclass) == 0)
		{
			array_push($prereq, $show[1]);
		}
		
	}
		
		}
		}
}

}	
getpre($show[1], $mainclass);		
	
	
		
	
	}
}
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

<body>
<input type="button" value="back" onclick="location.href='index.php'"/><br>
<div id="container" style="width:1200px">

<div id="header" class="header">
<h1 style="margin-bottom:0;">Video</h1></div>

<div id="content" style="background-color:#EEEEEE;height:1400px;width:800px;float:left;">
<?php
$user = $_SESSION["user_name"];
$url = $_GET["url"];
$classname = $_GET["class"];
$youtubeid = youtubeID($url);
$instance = $_GET["instance"];
echo "<iframe title='YouTube video player' class='youtube-player' type='text/html' 
width='640' height='390' src='http://www.youtube.com/embed/".$youtubeid."'
frameborder='0' allowFullScreen></iframe>";
?>
<div>
<br><br>
 <form action="" method="post">
 <?php
 $nameuser = $_SESSION["user_name"];
 $check1 = mysql_query("select * from userlearnt, learntvideos where userlearnt.user_name = '$nameuser' and userlearnt.videoid != '0' and learntvideos.name = '$instance' and learntvideos.id=userlearnt.videoid");
	$ccount = mysql_num_rows($check1);
	if($ccount <= 0)
	{
		 echo "<input type='submit' name='notseen' value='Mark as learnt'/>";
	}
	else
	{
		echo "<input type='submit' name='seen' value='Mark as unlearnt'/>";
	}
 ?>
 </form>
 </div>
 <?php
 if(isset($_POST["notseen"]))
 {
	$getid = "";
	$uid = $_SESSION["user_id"];
	$in1 = mysql_query("insert into learntvideos (name, url, class) values ('$instance', '$url', '$classname')");
		if($in1)
		{
			$rid = mysql_query("select id from learntvideos where url='$url'");
			$ridfetch = mysql_fetch_array($rid);
			$getid = $ridfetch["id"];
		}
		$in2 = mysql_query("insert into userlearnt (user_name, videoid) values ('$user', '$getid')");
		if($in2)
		{
		header("location:resultmain.php?instance=".$instance."&class=".$classname."&url=".$url);
			
		}
	
 }
 else if(isset($_POST["seen"]))
 {

	$rid1 = mysql_query("select id from learntvideos where url='$url'");
	$ridfetch1 = mysql_fetch_array($rid1);
	$getid1 = $ridfetch1["id"];
	$del1 = mysql_query("delete from learntvideos where url = '$url'");
	$del2 = mysql_query("delete from userlearnt where videoid = '$getid1'");
	if($del1 && $del2)
	{
		//echo "<font color='green'> Success. Why not learn it now? </font>";
		header("location:resultmain.php?instance=".$instance."&class=".$classname."&url=".$url);
	}
 }
 ?>
</div>
<div id="menu" style="background-color:#F3E5AB;height:1400px;width:400px;float:left;">
<div align="center">
<h3> Recommended videos </h3>
</div>
<?php
$starttime = microtime(true);
$newclass = "";
$classname = $_GET["class"];
$instance = $_GET["instance"];
$rtq = mysql_query("select class from instanceclass where instance = '$instance'");
$rte =  mysql_fetch_array($rtq);
$mainc = $rte["class"];
$lk = getchild($classname);
if(count($lk) == 0)
{
	$newclass = $classname;
}
else
{
	foreach($lk as $t)
	{
		$iy = getindividuals($t);
		foreach($iy as $u)
		{
			if(strcmp($u, $instance) == 0)
			{
				$newclass = $t;
			}
		}
	}
}
$parent = array();
$parent = getparent($newclass);
$simr = array();
foreach($parent as $par)
{
if($par != "Concept")
{
$simi = getindividuals($par);
foreach($simi as $pr)
{
	if($pr != $instance)
	{
	//echo "<br>".$pr;
	array_push($simr, $pr);
	}
}
}
}

$simr = array_unique($simr);
getpre($newclass, $mainc);
?>
<div align="center">
<?php
if(haspre($newclass))
{
	echo "Prerequisite video : ";
}
?>
<br><br>
</div>
<?php
$prereq = array_unique($prereq);
$individuals_array = array();
foreach($prereq as $p)
{
	$inp = getindividuals($p);
	foreach($inp as $r)
	{
		array_push($individuals_array, $r);
	}
}
$individuals_array = array_unique($individuals_array);
$individuals_array = array_merge($individuals_array, $simr);
$individuals_array = array_unique($individuals_array);
$lvideos = array();
$cquery = mysql_query("select learntvideos.name from learntvideos, userlearnt where userlearnt.user_name = '$user' and userlearnt.videoid = learntvideos.id");
while($cqr = mysql_fetch_array($cquery))
{
	array_push($lvideos, $cqr["name"]);
}
$individuals_new = array_diff($individuals_array, $lvideos);
foreach($individuals_new as $pa)
{
	$newq1 = mysql_query("select * from instanceclass where instance='$pa'");
	$newq2 = mysql_fetch_array($newq1);
	$cval = $newq2["class"];
	$uvalue = $newq2["url"];
	echo "<div style='margin-left:40px'>";
	echo "<a    target='_blank' href='resultmain.php?instance=".$pa."&class=".$cval."&url=".$uvalue."'><img src='thumbnails/".youtubeID($uvalue).".jpg'/><br>".$pa."</a><hr>";
	echo "</div>";
}
//sim
$endtime = microtime(true) - $starttime;
//echo round($endtime, 4);
?>
<br>
<br><br>
</div>




</div>
</body>
</html>