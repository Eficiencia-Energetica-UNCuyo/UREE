<?php
//setting header to json
header('Content-Type: application/json');
//database
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'maria');
define('DB_PASSWORD', 'maria');
define('DB_NAME', 'Corriente');



$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
$query2= "set @csum := 0";
$query ="select DataDate as DateAnterior, (@csum := @csum + energia) as acumuladoAnterior from (select cast(t.DataDate as date) as DataDate, SUM(energia) as energia from General t where (DataDate between DATE_FORMAT(NOW() - INTERVAL 1 MONTH,'%Y-%m-01') AND DATE_FORMAT(NOW() - INTERVAL 1 MONTH,'%Y-%m-31')) group by cast(t.DataDate as date) order by cast(t.DataDate as date) asc) as tabla order by DataDate";
$query3 = "SELECT DataDate as DateActual, (@csum := @csum + energia) as acumuladoActual from (select cast(t.DataDate as date) as DataDate, SUM(energia) as energia from General t where (DataDate between DATE_FORMAT(NOW() ,'%Y-%m-01') AND NOW()) group by cast(t.DataDate as date) order by cast(t.DataDate as date) asc) as tabla order by DataDate";


$seteo = $mysqli->query($query2);
$anterior = $mysqli->query($query);
$seteoagain = $mysqli->query($query2);
$actual= $mysqli->query($query3);
//loop through the returned data
$data = array();
foreach ($actual as $row) {
	$data[] = $row;
}
foreach ($anterior as $row) {
	$data[] = $row;
}


$mysqli->close();

print json_encode($data);
?>
