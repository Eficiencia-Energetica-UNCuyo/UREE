<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>JS Bin</title>
</head>
<body>
  <header><h1></h1></header>
<nav>

  <ul style="height:200px; width:18%;overflow:hidden; overflow-y:scroll;">

    <?php
  define('DB_HOST', 'localhost');
  define('DB_USERNAME', 'maria');
  define('DB_PASSWORD', 'maria');
  define('DB_NAME', 'Corriente');

  $mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
  if(!$mysqli){
  	die("Connection failed: " . $mysqli->error);
  }

  $sqlmax="select max(oficina) from General;";
  $sqlcrear="select Individuo, Variacion_Porcentual from Ranking order by Variacion_Porcentual asc;";
  $res = $mysqli->query($sqlmax);
  $maximo = $res->fetch_assoc();
  $maximo = $maximo['max(oficina)'];
  $result = mysql_query($sqlcrear);
$result = $mysqli->query($sqlcrear);

$yourArray = array();

$index = 0;
while($row = $result->fetch_assoc()){
     $yourArray[$index] = $row;
     $index++;
}
$decimales=4;
echo "<table>";
for($i=0;$i<$maximo;$i++){
echo "<tr>";
$variable=$yourArray[$i]['Individuo'];
echo "<td>";
echo "<img src='../avatares/$variable.svg'>";
echo "</td>";
echo "<td>";

echo $variable;
echo "</td>";

echo "<td>";
$yourArray[$i]['Variacion_Porcentual'] = (1-round($yourArray[$i]['Variacion_Porcentual'], $decimales))*100;
echo $yourArray[$i]['Variacion_Porcentual'];
echo "%";
echo "</td>";
echo "</tr>";
}
echo "</table>";

  $mysqli->close();

    ?>

  </ul>
  </nav>

</body>
</html>
