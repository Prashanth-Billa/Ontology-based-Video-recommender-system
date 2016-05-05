<?php
session_start();
if(!$_SESSION["user_name"]) {
	header("Location:index.php");
}
include "connect.php";
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
function getconceptname($name)
{
		require_once( "sparqllib.php" );
$db = sparql_connect( "http://localhost:3030/dataset/query" );
if( !$db ) { print sparql_errno() . ": " . sparql_error(). "\n"; exit; }
sparql_ns("ns", "http://www.semanticweb.org/amrit/ontologies/2014/2/untitled-ontology-8#");
sparql_ns("rdf", "http://www.w3.org/1999/02/22-rdf-syntax-ns#");
sparql_ns("owl", "http://www.w3.org/2002/07/owl#");
sparql_ns("rdfs", "http://www.w3.org/2000/01/rdf-schema#");
sparql_ns("xsd", "http://www.w3.org/2001/XMLSchema#");
$sparql1 = "SELECT ?x
WHERE { 
   ns:".$name." ns:hasConceptName ?x . 
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
		
		return $row1[$field1];
		
	}
}
}
?>
<html>
<head>

    	<title>
        Recommendation System using Ontology
        </title>
    <link rel="stylesheet" href="style.css" />
	<link rel="stylesheet" href="css/FileTreeView.css" />
	<script type="text/javascript" src="jquery-1.11.0.min.js"></script>

	<script type="text/javascript" src="FileTreeView.js"></script>
	<script>
	$(function() {
		$('#root_tree').fileTreeView('#expandAll', '#collapseAll', 'folder');
	});
	</script>
    </head>
<body>
<input type="button" value="Home" onclick="location.href='dashboard.php'"/><br>
<div align="center">
	<img src="images/search.jpg" width="90px"/><br>
</div>
    <header>
    	<h3 align="center" class="header">
        Semantic Recommender using Ontology
        </h3>
        <br />
        <div id="formdiv" align="center">
	
      <form id="form1" name="form1" method="post" action="">
	  
         <input placeholder="enter your query" name="searchterm" type="text" class="searchterm" value="" />
        <input type="submit" value="submit" name="ssearch" />
      </form>
      </div>
    </header>
    <br />
    <hr />
	<?php
	if(isset($_POST["ssearch"]))
	{
$v = $_POST["searchterm"];
$value = str_replace(' ', '', $v);
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
echo "<ul id='root_tree'>";
$unq = array();
$unq1 = array();
while( $row = sparql_fetch_array( $result ) )
{
	
	$show = "";
	
	foreach( $fields as $field )
	{
		$show = explode("#", $row[$field]);
		$indclass = getindividuals($show[1]);
			foreach($indclass as $indi)
			{	
				$cname = getconceptname($indi);
				
				if(strpos(strtolower($cname),strtolower($value)) !== false)
				{
					array_push($unq1, $indi);
					
					
				}
			}
		if(strpos(strtolower($show[1]),strtolower($value)) !== false)
		{
			$flag = 1;
			//$url = geturl($show[1]);
			
			//$videoname = getname($show[1]);
			//echo "<li><a href='resultmain.php?url=".$url."'><strong>".$show[1]."</strong></a></li>";
			//array_push($unq, $show[1]);
			$sparql1 = "SELECT ?subClass WHERE { ?subClass rdfs:subClassOf  ns:".$show[1]." }";
			
$result1 = sparql_query( $sparql1 ); 
if( !$result1 ) { print sparql_errno() . ": " . sparql_error(). "\n"; exit; }
 $flag1 = 0;
$fields1 = sparql_field_array( $result1 );
//print "<p>Number of rows: ".sparql_num_rows( $result )." results.</p>";
if(sparql_num_rows( $result1 ) <= 0)
{
	array_push($unq, $show[1]);
}
while( $row1 = sparql_fetch_array( $result1 ) )
{

	$show1 = "";
	foreach( $fields1 as $field1 )
	{
		$show1 = explode("#", $row1[$field1]);
		
			//echo "<li><a href='resultmain.php?url=".$url."'><strong>".$show1[1]."</strong></a></li>";
			array_push($unq, $show1[1]);
		
		
		
	}
	
}
			
		}
		else
		{
				$sparql1 = "SELECT ?subClass WHERE { ?subClass rdfs:subClassOf  ns:".$show[1]." }";
$result1 = sparql_query( $sparql1 ); 
if( !$result1 ) { print sparql_errno() . ": " . sparql_error(). "\n"; exit; }
 $flag1 = 0;
$fields1 = sparql_field_array( $result1 );
//print "<p>Number of rows: ".sparql_num_rows( $result )." results.</p>";
while( $row1 = sparql_fetch_array( $result1 ) )
{

	$show1 = "";
	foreach( $fields1 as $field1 )
	{
		$show1 = explode("#", $row1[$field1]);
		if(strpos(strtolower($show1[1]),strtolower($value)) !== false)
		{
			//echo "<li><a href='resultmain.php?url=".$url."'><strong>".$show1[1]."</strong></a></li>";
			array_push($unq, $show1[1]);
		}
		
		
	}
	
}
		}
	
	}
}
$rset = array_unique($unq);
$unqset = array_unique($unq1);

echo "<div align='center'><b><font color='#39F'>";
echo "Your query : <font color='green'>".$v."</font></font><br>";
echo "</div>";
$array_f = array();
foreach($rset as $r)
{
	$flag = 1;
	$url = geturl($r)[1];
	$instance = geturl($r)[0];
	//echo "<li><a href='resultmain.php?instance=".$instance."&class=".$r."&url=".$url."'><strong>".$r."</strong></a></li>";
	$rt = array();
	$rt = getindividuals($r);
	$rt  = array_unique($rt);
	
	foreach($rt as $ind)
	{
		array_push($array_f, $ind);
	}
	
	
}
foreach($unqset as $uv)
{
	array_push($array_f, $uv);
}
$array_f = array_unique($array_f);
echo "<div align='center'><font color='#39F'>";
echo "<br>".count($array_f)." results found<br></font></div>";
foreach($array_f as $p)
{
$sq = mysql_query("select class, url from instanceclass where instance = '$p'");
	$sqq = mysql_fetch_array($sq);
	echo "<a    target='_blank' href='resultmain.php?instance=".$p."&class=".$sqq["class"]."&url=".$sqq["url"]."'><img src='thumbnails/".youtubeID($sqq["url"]).".jpg'/><br>".$p."</a>";
	echo "<hr>";

}
}

$inhere = 1;
?>
</body>


</html>