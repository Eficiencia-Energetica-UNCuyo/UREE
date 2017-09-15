<?php
//setting header to json
header('Content-Type: application/json');
//database
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'maria');
define('DB_PASSWORD', 'maria');
define('DB_NAME', 'Corriente');
//get connection
//$q = $_REQUEST["q"];
$ini = $_REQUEST["ini"];
$fini = $_REQUEST["fini"];
$nombre = $_REQUEST["nombre"];



$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if(!$mysqli){
	die("Connection failed: " . $mysqli->error);
}
if(empty($_REQUEST["ini"]) || empty($_REQUEST["fini"])){
	$query = sprintf("SELECT * FROM $nombre");
}else {
	$query = sprintf("SELECT * FROM $nombre WHERE DataDate >= '$ini 00:00:00' AND DataDate <= '$fini 23:59:59'");
}
//query to get data from the table
//execute query
$result = $mysqli->query($query);
//loop through the returned data
$data = array();
foreach ($result as $row) {
	$data[] = $row;
}
//free memory associated with result
$result->close();
//close connection
$mysqli->close();
//now print the data
print json_encode($data);
?>
