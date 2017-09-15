<?php
//setting header to json
header('Content-Type: application/json');
//database
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'maria');
define('DB_PASSWORD', 'maria');
define('DB_NAME', 'Prueba');
//get connection
$q = $_REQUEST["q"];
$ini = $_REQUEST["ini"];
$fini = $_REQUEST["fini"];

$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if(!$mysqli){
	die("Connection failed: " . $mysqli->error);
}
if(empty($_REQUEST["ini"]) || empty($_REQUEST["fini"])){
	$query = sprintf("SELECT id, Temp, Hum,Pir,Ventana_1,Ventana_2,DataDate FROM Oficina_$q");
}else {
	$query = sprintf("SELECT * FROM Oficina_$q WHERE DataDate >= '$ini 00:00:00' AND DataDate <= '$fini 23:59:59'");
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
