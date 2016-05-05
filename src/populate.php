<?php
include "connect.php";
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
$d1 = mysql_query("drop table instanceclass");
$t = mysql_query("create table instanceclass (
	instance varchar(100) not null, 
	class varchar(100) not null,
	url varchar(100) not null,
	unique key(instance)
);");
$d2 = mysql_query("drop table concepts");
$t2 = mysql_query("create table concepts (
	conceptid int not null, 
	conceptname varchar(100) not null,
	primary key(conceptid)
);");
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
$j1 = 1;
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
	//echo "<li><a href='#'><strong>".$show[1]."</strong></a></li>";
	$inconcept = mysql_query("insert into concepts values('$j1', '$show[1]')");
	$j1 = $j1 + 1;
	$indi1 = array();
	$indi1 = getindividuals($show[1]);
				$urlvalue = geturl($show[1]);
		foreach($indi1 as $i1)
		{
		$ins = mysql_query("insert into instanceclass (instance, class, url) values ('$i1', '$show[1]', '$urlvalue[1]')");
		
		}
		}
else
{
	//echo "<li><a href='#'><strong>".$show[1]."</strong></a>";
$inconcept2 = mysql_query("insert into concepts values('$j1', '$show[1]')");
$j1 = $j1 + 1;
	
	
while( $row1 = sparql_fetch_array( $result1 ) )
{

	$show1 = "";
	foreach( $fields1 as $field1 )
	{
	
		$show1 = explode("#", $row1[$field1]);
		$urlvalue = geturl($show1[1]);
		//echo "<ol><li><a target='_blank' href='resultmain.php?instance=".$urlvalue[0]."&class=".$show1[1]."&url=".$urlvalue[1]."'><strong>".$show1[1]."</strong></a></ol>";
		$indi = array();
		$indi = getindividuals($show1[1]);
		
		foreach($indi as $i)
		{
		$ins = mysql_query("insert into instanceclass (instance, class, url) values ('$i', '$show[1]', '$urlvalue[1]')");
		
		}
	}
	
}
echo "</li>";
}
		
	
	}
	
}


?>