<?php
//setting header to json
header('Content-Type: application/json');
//database
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'maria');
define('DB_PASSWORD', 'maria');
define('DB_NAME', 'Corriente');

$decimales = 0;

$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if(!$mysqli){
	die("Connection failed: " . $mysqli->error);
}
//OBTENCION DEL CONSUMO TOTAL DE LAS INSTALACIONES.
$query = "select equipo,sum(energia) as energia from General where (DataDate between DATE_FORMAT(NOW() ,'%Y-%m-01') AND NOW()) group by equipo ;";
//$contotal = mysqli_num_rows($mysqli->query($query1));
/*$res = $mysqli->query($query1);
$contotal = $res->fetch_assoc();
$equipo =array();

$power = round($contotal['sum(energia)'], $decimales);
$equipo[$contotal['equipo']]=$power;
$data=$equipo;*/
$result = $mysqli->query($query);
//loop through the returned data
$data = array();
foreach ($result as $row) {
	$data[] = $row;
}
//free memory associated with result
$result->close();
//free memory associated with result
//$res->close();
//$result->close();
//close connection
$mysqli->close();
//now print the data
//print json_encode($data);
print json_encode($data);
?>
