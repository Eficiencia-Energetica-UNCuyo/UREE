<html>
<?php
//setting header to json
header('Content-Type: application/json');
//database
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'maria');
define('DB_PASSWORD', 'maria');
define('DB_NAME', 'Corriente');

$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if(!$mysqli){
	die("Connection failed: " . $mysqli->error);
}
//OBTENCION DEL CONSUMO TOTAL DE LAS INSTALACIONES.
$query1 = "create table if not exists holiwis(id int (35) NOT NULL AUTO_INCREMENT,energia int (35) NOT NULL, DataDate varchar(255) NOT NULL, PRIMARY KEY (id));";
echo 1;
//$contotal = mysqli_num_rows($mysqli->query($query1));
$res = $mysqli->query($query1);

for ($i=1; $i <= 30; $i++) {
	if $i < 10 {
	$query2 = "INSERT INTO holiwis (energia, DataDate) VALUES ($i*10,'2017-07-0$i');";
	}else{$query2 = "INSERT INTO holiwis (energia, DataDate) VALUES ($i*10,'2017-07-$i');";};
	$res = $mysqli->query($query2);
	
	}
$mysqli->close();
?>
</html>
