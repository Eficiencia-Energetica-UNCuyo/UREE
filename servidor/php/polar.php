<?php
//setting header to json
header('Content-Type: application/json');
//database
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'maria');
define('DB_PASSWORD', 'maria');
define('DB_NAME', 'Corriente');

$decimales = 1;

$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if(!$mysqli){
	die("Connection failed: " . $mysqli->error);
}
//OBTENCION DEL CONSUMO TOTAL DE LAS INSTALACIONES.
$query1 = "select SUM(energia) FROM General;";
$res = $mysqli->query($query1);
$contotal = $res->fetch_assoc();
$contotal = round($contotal['SUM(energia)'], $decimales);

//OBTENCION DE LA CANTITADAD TOTAL DE OFICINAS, $MAXIMO SERA ESE NUMERO.
$sql="select max(oficina) from General;";
$res = $mysqli->query($sql);
$maximo = $res->fetch_assoc();
$maximo = $maximo['max(oficina)'];
//LOOP ASIGNANDO A UN C/COMPONENTE DE UN VECTOR EL CONSUMO TOTAL DE CADA OFICINA.
$oficinas = array();
for ($i=1; $i <= $maximo; $i++) {
	$query2 = "select SUM(energia) FROM General WHERE oficina=$i;";
	$res = $mysqli->query($query2);
	$row = $res->fetch_assoc();
	$oficinas[] = round($row['SUM(energia)'], $decimales);
	//$offi_num[] ="Oficina_$i"
	}

$porcentaje = array();
foreach ($oficinas as $row) {
	$asd = ($row/$contotal)*100;
	$porcentaje[] = round($asd, $decimales);
}
$data = $porcentaje;
//$c=array_combine($offi_num,$porcentaje);
//free memory associated with result
$res->close();
$result->close();
//close connection
$mysqli->close();

print json_encode($data);
?>
