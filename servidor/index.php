<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <!--Todas las imagenes de fondo fueron libremente descargadas de https://www.pexels.com/ y https://unsplash.com/, Los iconos pertenecen a al Instituto de Energía y a EMESA.-->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="iconfont/material-icons.css">
    <link href="css/datepicker.css" rel="stylesheet" type="text/css"/>
    <!--<link rel="stylesheet" href="css/pushy-buttons.min.css">-->
    <script type="text/javascript" src="js/aos.js"></script>
    <script type="text/javascript" src="js/anime.min.js"></script>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>
    <script type="text/javascript" src="js/jquery.arctext.js"></script>
    <script type="text/javascript" src="js/Chart.bundle.min.js"></script>
    <script type="text/javascript" src="js/GraficoFinal.js"></script>
    <script type="text/javascript" src="js/Myjs.js"></script>
   <title>UREE</title>
  </head>
  <body>
    <header class="encabezado">
      <div id="slideit">
        <div id="dimmer">
          <div class="container-header" >
              <hr id="top">
              <h2 class="titulos" id="titu1">UREE en Edificios Públicos</h2>
              <div id="svg">
                <i class="material-icons">brightness_7</i>
                <i class="material-icons" id="sol-mid">brightness_7</i>
                <i class="material-icons">brightness_7</i>
              </div>
              <h3 class="titulos"> Auditoría y /Cambio/ de Hábitos</h3><br>
              <p>UREE es un proyecto que tiene como objetivo el uso de la energía <br>
                 de forma consciente y la reducción del consumo con el motivo de <br>
                 reducir el gasto enegético y proteger el medio ambiente.</p><br><hr>
              <p class="botones">
                <a href="#intro" id="boton1">General</a>
                <a href="#work" id="boton2">Mi Consumo</a>
                <a href="#about" id="boton3">Mi oficina</a><!--?subject=UREE%20en%20EMESA-->
                <!--<a href=href="mailto:eficienciaenergeticauncuyo@gmail.com" id="boton4">Contacto</a>-->
                <!-- <button type="button" name="button" id="boton4" onclick="mail()">Contacto</button> -->
                <a href="#slideit" id="boton4" onclick="mail()">Contacto</a>
              </p>
           </div>
         </div>
      </div>
     </div>
    </header>

    <div class="grid-lista-canvas" id="intro">
      <div class="texto" >
        <div class="chiquito">


          <?php
                define('DB_HOST', 'localhost');
                define('DB_USERNAME', 'maria');
                define('DB_PASSWORD', 'maria');
                define('DB_NAME', 'Corriente');

                $mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
                if(!$mysqli){
                	die("Connection failed: " . $mysqli->error);
                }

                $sqlmax="select count(Individuo) from Ranking;";
                $sqlcrear="select Individuo, Variacion_Porcentual from Ranking order by Variacion_Porcentual asc;";
                $res = $mysqli->query($sqlmax);
                $maximo = $res->fetch_assoc();
                $maximo = $maximo['count(Individuo)'];
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
                $numero=rand(1,28);
                echo "<img class='avatar' src='../avatares/avatar-$numero.png'>";
                echo "</td>";
                echo "<td>";
                $variable=str_replace("_"," ","$variable");
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
                if ($yourArray[$i]['Variacion_Porcentual']==0){

                  echo "<td>";
                  echo "<img class='flecha' src='../avatares/flechanegra.svg'>";
                  echo "</td>";
                }

                echo "</tr>";
                }
                echo "</table>";

                $mysqli->close();
          ?>
        </div>
        
        <div class="flex-container">
        <a href="#slideit" class="subir" class="flex-item">Inicio</a>
        <a href="./Gerais/gerais.php" class="subir" class="flex-item">Datos Generales</a>
        </div>
        
        
      </div>
      <div class="canvas">
        <canvas id="polar_1"></canvas>
      </div>
    </div>

    <div class="grid-canvas-texto" id="work">
      <div class="texto">
        <p style="text-align : left;">En esta sección puede visualizar los registros de su consumo energético.<br><br>
          Presione el botón <i class="material-icons" style="font-size:1em" >insert_photo</i> y escriba su nombre,
           posteriormente indique el intervalo de fechas que desee visulizar, luego haga click en "proceder". </p>
        <a href="#slideit" class="subir">Inicio</a>
      </div>
      <div class="canvas">
        <div id="rango2" data-aos="fade-right" data-aos-offset="300" data-aos-easing="ease-in-sine"
             data-aos-anchor-placement="center-bottom" class="circular" ondblclick="contraer2()">
             <a href="#work" onclick="expand2()"><i class="material-icons">insert_photo</i></a>
          <form class="rango">
        		<p>Usuario: <input id=oli_corriente type="text" placeholder="p.e: 'Axel Poretti'"
              onclick="this.select()" onKeyDown="if(event.keyCode==13) holandacorriente();"></p>
        		<p>fecha inicio: <input id=ini_corriente class="datepicker" type="text" placeholder="p.e: '2017-05-10'"></p>
        		<p>fecha final: <input id=fini_corriente class="datepicker" type="text" placeholder="p.e: '2017-05-10'"></p>
        		<button type="button" name="button" onclick="holandacorriente()">Procesar</button>
        	</form>
        </div>
        <canvas id="myChart2"></canvas>
      </div>
    </div>

    <div class="grid-texto-canvas" id="about">
      <div class="texto">
        <p style="text-align : left;">En esta sección puede visualizar los registros de humedad y temperatura en su oficina.<br><br>
          Presione el botón <i class="material-icons" style="font-size:1em" >insert_photo</i> y seleccione el número de oficina,
           posteriormente indique el intervalo de fechas que desee visulizar, luego haga click en "proceder". </p>
        <a href="#slideit" class="subir">Inicio</a>
      </div>
      <div class="canvas">
        <div id="rango3" data-aos="fade-right" data-aos-offset="300" data-aos-easing="ease-in-sine"
             data-aos-anchor-placement="center-bottom" class="circular" ondblclick="contraer()">
             <a href="#about" onclick="expand()"><i class="material-icons">insert_photo</i></a>
          <form class="rango">
        		<p>oficina: <input id=oli type="text" placeholder="p.e: '1'"
              onclick="this.select()" onKeyDown="if(event.keyCode==13) holanda();"></p>
        		<p>fecha inicio: <input id=ini class="datepicker" type="text" placeholder="p.e: '2017-05-10'"></p>
        		<p>fecha final: <input id=fini class="datepicker" type="text" placeholder="p.e: '2017-05-10'"></p>
        		<button type="button" name="button" onclick="holanda()">Procesar</button>
        		<!--<p id=prom></p>
        		<input type="text" placeholder="Temp o Hum">
        		<button type="button" name="button" onclick="promedio(this.value)">Chingale el promedio</button>-->
      		</form>
        </div>
        <canvas id="myChart3" class="graficos-linea"></canvas>
      </div>
    </div>

  </body>
</html>
