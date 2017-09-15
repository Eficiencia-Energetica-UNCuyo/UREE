<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Server</title>
    <style media="screen">
    @font-face {
        font-family: Source Sans Pro;
        src: url(../Fonts/SourceSansPro-Regular.ttf);
    }
    * {font-family: font-family: 'Source Sans Pro', sans-serif;
      color: black;text-align: center;
      text-transform: uppercase;
      letter-spacing: 0.2rem;
      font-size: 0.8rem;
      line-height: 2;}
    hr {height: 1px; background-color: rgba(0,0,0,0.9); border:none;width: 60%;}
    </style>
  </head>
  <body>

    <?php
    echo "<h1>Esperando a recibir datos...</h1><br><hr>";
    if(!empty($_GET["energia"]) && !empty($_GET["nombre"]) && !empty($_GET["equipo"]) && !empty($_GET["oficina"])){
    $tabla=$_GET["nombre"];
    $oficina=$_GET["oficina"];
    $energia=$_GET["energia"];
    $equipo=$_GET["equipo"];
    $servername = "localhost";
    $username = "maria";
    $password = "maria";
    $dbname = "Corriente";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $tablaoficina="Oficina_$oficina";
    $sqlcrear2="CREATE TABLE IF NOT EXISTS $tabla(id int NOT NULL AUTO_INCREMENT,oficina varchar(255) NOT NULL ,equipo varchar(255) NOT NULL,energia varchar(255) NOT NULL, DataDate DateTime NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (id));";
    $sqlcargar2 ="INSERT INTO $tabla (oficina, equipo, energia) VALUES ('$oficina','$equipo',$energia);";

    $sqlcrear="CREATE TABLE IF NOT EXISTS Ranking(Individuo varchar(50) NOT NULL,Variacion_Porcentual float(6) NOT NULL, PRIMARY KEY (Individuo));";
    $sqlcargar ="INSERT INTO Ranking (Individuo, Variacion_Porcentual) VALUES('$tabla',(select (SELECT Promedio from (             SELECT* FROM(select id as id,Oficina as Oficina,cast(t.DataDate as date) as dia, avg(t.energia) as Promedio from $tabla t group by cast(t.DataDate as date) order by cast(t.DataDate as date) desc)AS Tabla               ) as hola where id=(SELECT MAX( id )FROM (             SELECT* FROM(select id as id,Oficina as Oficina,cast(t.DataDate as date) as dia, avg(t.energia) as Promedio from $tabla t group by cast(t.DataDate as date) order by cast(t.DataDate as date) desc)AS Tabla               ) as hola)) / (SELECT Promedio from (             SELECT* FROM(select id as id,Oficina as Oficina,cast(t.DataDate as date) as dia, avg(t.energia) as Promedio from $tabla t group by cast(t.DataDate as date) order by cast(t.DataDate as date) desc)AS Tabla               ) as hola where id=(SELECT MIN( id )FROM (             SELECT* FROM(select id as id,Oficina as Oficina,cast(t.DataDate as date) as dia, avg(t.energia) as Promedio from $tabla t group by cast(t.DataDate as date) order by cast(t.DataDate as date) desc)AS Tabla               ) as hola))  as Relacion) )ON DUPLICATE KEY UPDATE Variacion_Porcentual=(select (SELECT Promedio from (             SELECT* FROM(select id as id,Oficina as Oficina,cast(t.DataDate as date) as dia, avg(t.energia) as Promedio from $tabla t group by cast(t.DataDate as date) order by cast(t.DataDate as date) desc)AS Tabla               ) as hola where id=(SELECT MAX( id )FROM (             SELECT* FROM(select id as id,Oficina as Oficina,cast(t.DataDate as date) as dia, avg(t.energia) as Promedio from $tabla t group by cast(t.DataDate as date) order by cast(t.DataDate as date) desc)AS Tabla               ) as hola)) / (SELECT Promedio from (             SELECT* FROM(select id as id,Oficina as Oficina,cast(t.DataDate as date) as dia, avg(t.energia) as Promedio from $tabla t group by cast(t.DataDate as date) order by cast(t.DataDate as date) desc)AS Tabla               ) as hola where id=(SELECT MIN( id )FROM (             SELECT* FROM(select id as id,Oficina as Oficina,cast(t.DataDate as date) as dia, avg(t.energia) as Promedio from $tabla t group by cast(t.DataDate as date) order by cast(t.DataDate as date) desc)AS Tabla               ) as hola))  as Relacion);";

    $sqlcrear4="CREATE TABLE IF NOT EXISTS $tablaoficina(id int NOT NULL AUTO_INCREMENT,oficina varchar(255) NOT NULL ,equipo varchar(255) NOT NULL,energia varchar(255) NOT NULL, DataDate DateTime NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (id));";
    $sqlcargar4 ="INSERT INTO $tablaoficina (oficina, equipo, energia) VALUES ('$oficina','$equipo',$energia);";


    $sqlcrear3="CREATE TABLE IF NOT EXISTS RankingOficina(Oficina varchar(50) NOT NULL,Variacion_Porcentual float(6) NOT NULL, PRIMARY KEY (Oficina));";
    $sqlcargar3 ="INSERT INTO RankingOficina (Oficina, Variacion_Porcentual) VALUES('$tablaoficina',(select (SELECT Promedio from (             SELECT* FROM(select id as id,Oficina as Oficina,cast(t.DataDate as date) as dia, avg(t.energia) as Promedio from $tablaoficina t group by cast(t.DataDate as date) order by cast(t.DataDate as date) desc)AS Tabla               ) as hola where id=(SELECT MAX( id )FROM (             SELECT* FROM(select id as id,Oficina as Oficina,cast(t.DataDate as date) as dia, avg(t.energia) as Promedio from $tablaoficina t group by cast(t.DataDate as date) order by cast(t.DataDate as date) desc)AS Tabla               ) as hola)) / (SELECT Promedio from (             SELECT* FROM(select id as id,Oficina as Oficina,cast(t.DataDate as date) as dia, avg(t.energia) as Promedio from $tablaoficina t group by cast(t.DataDate as date) order by cast(t.DataDate as date) desc)AS Tabla               ) as hola where id=(SELECT MIN( id )FROM (             SELECT* FROM(select id as id,Oficina as Oficina,cast(t.DataDate as date) as dia, avg(t.energia) as Promedio from $tablaoficina t group by cast(t.DataDate as date) order by cast(t.DataDate as date) desc)AS Tabla               ) as hola))  as Relacion) )ON DUPLICATE KEY UPDATE Variacion_Porcentual=(select (SELECT Promedio from (             SELECT* FROM(select id as id,Oficina as Oficina,cast(t.DataDate as date) as dia, avg(t.energia) as Promedio from $tablaoficina t group by cast(t.DataDate as date) order by cast(t.DataDate as date) desc)AS Tabla               ) as hola where id=(SELECT MAX( id )FROM (             SELECT* FROM(select id as id,Oficina as Oficina,cast(t.DataDate as date) as dia, avg(t.energia) as Promedio from $tablaoficina t group by cast(t.DataDate as date) order by cast(t.DataDate as date) desc)AS Tabla               ) as hola)) / (SELECT Promedio from (             SELECT* FROM(select id as id,Oficina as Oficina,cast(t.DataDate as date) as dia, avg(t.energia) as Promedio from $tablaoficina t group by cast(t.DataDate as date) order by cast(t.DataDate as date) desc)AS Tabla               ) as hola where id=(SELECT MIN( id )FROM (             SELECT* FROM(select id as id,Oficina as Oficina,cast(t.DataDate as date) as dia, avg(t.energia) as Promedio from $tablaoficina t group by cast(t.DataDate as date) order by cast(t.DataDate as date) desc)AS Tabla               ) as hola))  as Relacion);";




    $sqlcrearcorrientegeneral="CREATE TABLE IF NOT EXISTS General(id int NOT NULL AUTO_INCREMENT,oficina varchar(255) NOT NULL , energia varchar(255) NOT NULL,equipo varchar(255) NOT NULL, DataDate DateTime NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (id));";
    $sqlcargarcorrientegeneral="INSERT INTO General (oficina, energia, equipo) VALUES ('$oficina',$energia, '$equipo');";

    if (mysqli_query($conn, $sqlcrear2)) {
      echo "Nueva tabla '$tabla' ha sido creada.<br>";
    } else {
      echo "Error: <br>" . mysqli_error($conn);
    }
    if (mysqli_query($conn, $sqlcargar2)) {
      echo "<p>New record created successfully on $tabla</p>";
    } else {
      echo "Error: <br>" . mysqli_error($conn);
    }
    if (mysqli_query($conn, $sqlcrear)) {
      echo "Nueva tabla '$tabla' ha sido creada.<br>";
    } else {
      echo "Error: <br>" . mysqli_error($conn);
    }
    if (mysqli_query($conn, $sqlcargar)) {
      echo "<p>New record created successfully on $tabla</p>";
    } else {
      echo "Error: <br>" . mysqli_error($conn);
    }

    if (mysqli_query($conn, $sqlcrear4)) {
      echo "Nueva tabla '$tabla' ha sido creada.<br>";
    } else {
      echo "Error: <br>" . mysqli_error($conn);
    }
    if (mysqli_query($conn, $sqlcargar4)) {
      echo "<p>New record created successfully on $tabla</p>";
    } else {
      echo "Error: <br>" . mysqli_error($conn);
    }

    if (mysqli_query($conn, $sqlcrear3)) {
      echo "Nueva tabla '$tabla' ha sido creada.<br>";
    } else {
      echo "Error: <br>" . mysqli_error($conn);
    }
    if (mysqli_query($conn, $sqlcargar3)) {
      echo "<p>New record created successfully on $tabla</p>";
    } else {
      echo "Error: <br>" . mysqli_error($conn);
    }

    if (mysqli_query($conn, $sqlcrearcorrientegeneral)) {
      echo "<p>New record created successfully on General</p>";
    } else {
      echo "Error: <br>" . mysqli_error($conn);
    }
    if (mysqli_query($conn, $sqlcargarcorrientegeneral)) {
      echo "<p>New record created successfully on General</p>";
    } else {
      echo "Error: <br>" . mysqli_error($conn);
    }
    mysqli_close($conn);
    echo "<hr>";
    }
    ?>
  </body>
</html>
      
