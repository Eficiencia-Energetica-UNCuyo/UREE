<?php
// Setting header to json
header('Content-Type: application/json');
// Database
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'maria');
define('DB_PASSWORD', 'maria');
define('DB_NAME', 'Corriente');

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
// Query to get data from the table
// Execute query
$result = $mysqli->query($query);
// Loop through the returned data
$data = array();
foreach ($result as $row) {
	$data[] = $row;
}
// Free memory associated with result
$result->close();
// Close connection
$mysqli->close();
// Now print the data
print json_encode($data);
?>
