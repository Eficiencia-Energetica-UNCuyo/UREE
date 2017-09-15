<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>



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
                $sqlcrear="select Oficina, Variacion_Porcentual from RankingOficina order by Variacion_Porcentual asc;";
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
                $variable=$yourArray[$i]['Oficina'];
                echo "<td>";
                echo '<svg xmlns="www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48"><path d="M40 36c2.21 0 3.98-1.79 3.98-4L44 10c0-2.21-1.79-4-4-4H8c-2.21 0-4 1.79-4 4v22c0 2.21 1.79 4 4 4H0c0 2.21 1.79 4 4 4h40c2.21 0 4-1.79 4-4h-8zM8 10h32v22H8V10zm16 28c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/></svg>';
                //echo "<img class='avatar' src='../avatares/$variable.svg'>";
                echo "</td>";
                echo "<td>";
                echo $variable;
                echo "</td>";
                echo "<td>";
                $yourArray[$i]['Variacion_Porcentual'] = (1-round($yourArray[$i]['Variacion_Porcentual'], $decimales))*100;
                echo $yourArray[$i]['Variacion_Porcentual'];
                echo "%";
                echo "</td>";

                if ($yourArray[$i]['Variacion_Porcentual']<0){
                  echo "<td>";
                  echo "<img class='flecha' src='../avatares/flecharoja.svg'>";
                  echo "</td>";
                }
                if ($yourArray[$i]['Variacion_Porcentual']>0){
                  echo "<td>";
                  echo "<img class='flecha' src='../avatares/flechaverde.svg'>";
                  echo "</td>";
                }
                if ($yourArray[$i]['Variacion_P