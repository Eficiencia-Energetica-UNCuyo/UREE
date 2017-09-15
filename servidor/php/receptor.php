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
    if(!empty($_GET["Temperatura"]) && !empty($_GET["Humedad"]) && !empty($_GET["PIR"]) && !empty($_GET["Ventana_1"]) && !empty($_GET["Ventana_2"]) && !empty($_GET["ipsrc"])){
    $tabla=$_GET["ipsrc"];
    $temp=$_GET["Temperatura"];
    $hum=$_GET["Humedad"];
    $pir=$_GET["PIR"];
    $Ventana_1=$_GET["Ventana_1"];
    $Ventana_2=$_GET["Ventana_2"];
    $servername = "localhost";
    $username = "maria";
    $password = "maria";
    $dbname = "Prueba";
    $tabla2="General";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    $conn2 = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sqlcrear2="CREATE TABLE IF NOT EXISTS $tabla2(id int NOT NULL AUTO_INCREMENT,Oficina varchar(255) NOT NULL ,Temp varchar(50) NOT NULL, Hum varchar(50) NOT NULL,Pir varchar(50) NOT NULL,Ventana_1 varchar(50) NOT NULL, Ventana_2 varchar(50) NOT NULL, DataDate DateTime NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (id));";
    $sqlcargar2 ="INSERT INTO $tabla2 (Oficina, Temp, Hum, Pir, Ventana_1, Ventana_2) VALUES ('$tabla',$temp, $hum, $pir, $Ventana_1, $Ventana_2);";
    $sqlcrear="CREATE TABLE IF NOT EXISTS $tabla(id int NOT NULL AUTO_INCREMENT, Temp varchar(50) NOT NULL, Hum varchar(50) NOT NULL,Pir varchar(50) NOT NULL,Ventana_1 varchar(50) NOT NULL, Ventana_2 varchar(50) NOT NULL, DataDate datetime NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (id));";
    $sqlcargar ="INSERT INTO $tabla (Temp, Hum, Pir, Ventana_1, Ventana_2) VALUES ($temp, $hum, $pir, $Ventana_1, $Ventana_2);";
      if (mysqli_query($conn2, $sqlcrear2)) {
        //echo "Nueva tabla '$tabla' ha sido creada.<br>";
    } else {
        //echo "Error: <br>" . mysqli_error($conn);
    }
    if (mysqli_query($conn2, $sqlcargar2)) {
        //echo "<p>New record created successfully on $tabla</p>";
    } else {
        //echo "Error: <br>" . mysqli_error($conn);
    }


    if (mysqli_query($conn, $sqlcrear)) {
    //echo "Nueva tabla '$tabla' ha sido creada.<br>";
} else {
    //echo "Error: <br>" . mysqli_error($conn);
}
if (mysqli_query($conn, $sqlcargar)) {
    //echo "<p>New record created successfully on $tabla</p>";
} else {
    //echo "Error: <br>" . mysqli_error($conn);
}

    mysqli_close($conn);
    echo "<hr>";
    }
    ?>
  </body>
</html>
