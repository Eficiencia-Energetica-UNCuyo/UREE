<!doctype html>
<html lang="en" prefix="og: http://ogp.me/ns#">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IDE: UREE </title>
    <meta name="description" content="UREE en EMESA. Una rápida referencia.">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,700,700i%7CMaitree:200,300,400,600,700&amp;subset=latin-ext" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="all" href="../static/css/base.css">
    <link rel="stylesheet" type="text/css" media="all" href="../static/css/colors.css">
    <link rel="stylesheet" type="text/css" media="all" href="../static/css/svg-icons.css">
    <!-- <script type="text/javascript" src="../js/jquery.min.js"></script> -->
    <script type="text/javascript" src="../js/jquery.js"></script>
    <!-- <script type="text/javascript" src="../js/Chart.bundle.min.js"></script> -->
    <script type="text/javascript" src="../js/Chart.bundle.js"></script>
    <script type="text/javascript" src="../js/gerais.js"></script>
    <link rel="shortcut icon" sizes="16x16" href="../static/images/favicons/favicon.png">
    <link rel="shortcut icon" sizes="32x32" href="../static/images/favicons/favicon-32.png">
    <link rel="apple-touch-icon icon" sizes="76x76" href="../static/images/favicons/favicon-76.png">
    <link rel="apple-touch-icon icon" sizes="120x120" href="../static/images/favicons/favicon-120.png">
    <link rel="apple-touch-icon icon" sizes="152x152" href="../static/images/favicons/favicon-152.png">
    <link rel="apple-touch-icon icon" sizes="180x180" href="../static/images/favicons/favicon-180.png">
    <link rel="apple-touch-icon icon" sizes="192x192" href="../static/images/favicons/favicon-192.png">
    <link rel="stylesheet" href="./master.css">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#333333">
  </head>
  <body>

    <main role="main">
      <article id="webslides">

        <!-- Quick Guide
          - Each parent <section> in the <article id="webslides"> element is an individual slide.
          - Vertical sliding = <article id="webslides" class="vertical">
          - <div class="wrap"> = container 90% / <div class="wrap size-50"> = 45%;
        -->

        <section class="bg-black aligncenter">
          <span class="background light" style="background-image:url('../imagenes/Fondo3.jpg')"></span>
          <div class="wrap">
          <h1>UREE</h1>
          <h4>Energizando a las personas</h4><br>
            <p class="text-shadow">UREE es un proyecto que tiene como objetivo el uso de la energía <br>
               de forma consciente y la reducción del consumo con el motivo de <br>
               reducir el gasto enegético y proteger el medio ambiente.</p><br>

          </div>
          <!-- .end .wrap -->
        </section>

        <section class="aligncenter">
          <!--.wrap = container (width: 90%) with fadein animation -->
          <header>
            <!--.wrap or <nav> = container 1200px -->
            <div class="wrap">
              <h2>Consumos</h2>
              <p class="text-intro">Porcentajes dentro de la empresa.</p>
            </div>
          </header>
          <div class="wrap">
            <div class="grid ms">
              <div class="column">
                		<script type="text/javascript">
                    // Solicitud ajax para obtener consumod acumulados mensualmente.
                		$.ajax({
                			url : "../php/GraficoEnergiaTotal.php?",
                			type : "GET",
                			success : function(data){
                        //Vectores para almacenar informcion de la base de datos.
                				var acumulado = [];
                				var DataDate = [];
                				var acumuladoan = [];
                				var DataDatean = [];

                				for(var i in data) {
                					acumulado.push(data[i].acumuladoActual);
                					DataDate.push(data[i].DateActual);
                					acumuladoan.push(data[i].acumuladoAnterior);
                					DataDatean.push(data[i].DateAnterior);

                				}

                        // Objetos de chartjs de configuracion para la representación en grafico lineal.

                				var chartdata = {
                					labels: DataDatean,
                					datasets: [
                						{
                							label: "Acumulado Actual",
                							yAxisID:"Energia",
                							fill: false,
                							backgroundColor: "rgba(255,99,132,1)",
                							borderColor: "rgba(255,99,132,1)",
                							pointHoverBackgroundColor: "rgba(255,99,132,1)",
                							pointHoverBorderColor: "rgba(255,99,132,1)",
                							data: acumulado
                						}
                						,
                						{
                							label: "Mes Anterior",
                							yAxisID:"Energia",
                							fill: false,
                							backgroundColor: "rgba(54, 162, 235, 1)",
                							borderColor: "rgba(54, 162, 235, 1)",
                							pointHoverBackgroundColor: "rgba(54, 162, 235, 1)",
                							pointHoverBorderColor: "rgba(54, 162, 235, 1)",
                							data: acumuladoan
                						}
                					]
                				};
                        //Generacion de los graficos
                				var ctx = $("#myChart3");
                				var LineGraph = new Chart(ctx, {
                					type: 'line',
                					data: chartdata,
                					options: {
                							scales: {
                									xAxes: [{
                											display: true,
                											scaleLabel: {
                			                            display: true
                			                        },
                											ticks: {
                													maxRotation: 0,
                													minRotation: 0,
                													fontColor: "#9a9ca5",
                													fontStyle: "bold",
                											}
                									}],
                									yAxes: [{
                											position:"left",
                											type: "linear",
                											id:"Energia",
                											ticks: {
                													fontColor: "rgb(154, 156, 165)",
                													fontStyle: "bold",
                													callback: function(label, index, labels) {
                																		return label+' kWh';
                													}
                											}
                										},{
                												position:"left",
                												type: "linear",
                												id:"Energia",
                												ticks: {
                														fontColor: "rgb(154, 156, 165)",
                														fontStyle: "bold",
                														callback: function(label, index, labels) {
                																			return label+' kWh';

                														}
                												}
                									}]
                							}
                						}
                				});
                			},
                			error : function(data) {} });
                		</script>
                    <div class="card-60">
                      <canvas id="myChart3"></canvas>
                    </div>
              </div>
              <div class="column">
                  <p style="padding-top:20%;">Este gráfico representa el consumo
                     total acumulado en la institución desde principio
                  de este mes hasta el día de la fecha. La otra curva
                  representa el consumo análogo del mes pasado.</p>
                </div>
            </div>
              <!-- end .column -->
          </div>
          <!-- end .wrap -->
        </section>
        <section class="aligncenter">
                  <div class="wrap">
                    <h2>Ranking</h2>
                    <div class="grid vertical-align">
                      <div class="column">
                        <?php
                              // PHP para el calculo del Ranking y generacion de tabla
                              define('DB_HOST', 'localhost');
                              define('DB_USERNAME', 'maria');
                              define('DB_PASSWORD', 'maria');
                              define('DB_NAME', 'Corriente');

                              $mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
                              if(!$mysqli){
                                die("Connection failed: " . $mysqli->error);
                              }
                              // Solicitudes a la base de datos
                              $sqlmax="select max(oficina) from General;";
                              $sqlcrear="select Individuo, Variacion_Porcentual from Ranking order by Variacion_Porcentual asc;";
                              $res = $mysqli->query($sqlmax);
                              $maximo = $res->fetch_assoc();
                              //Calcula la cantidad maxima de oficinas
                              $maximo = $maximo['max(oficina)'];
                              $result = $mysqli->query($sqlcrear);

                              $yourArray = array();

                              $index = 0;
                              while($row = $result->fetch_assoc()){
                                   $yourArray[$index] = $row;
                                   $index++;
                              }
                              $decimales=4;

                              if ($maximo>4){
                                $maximo=4;
                              }
                              // Creacion de las tablas de Ranking
                              echo "<table style='padding-top:5%;'>";
                              for($i=0;$i<$maximo;$i++){
                              echo "<tr>";
                              $variable=$yourArray[$i]['Individuo'];
                              echo "<td>";
                              $numero=rand(1,28);
                              // Asignacion de avatares a los individuos.
                              echo "<img class='avatar' src='../avatares/avatar-$numero.png'>";
                              echo "</td>";
                              echo "<td>";
                              echo $variable;
                              echo "</td>";
                              echo "<td>";
                              $yourArray[$i]['Variacion_Porcentual'] = (1-round($yourArray[$i]['Variacion_Porcentual'], $decimales))*100;
                              echo $yourArray[$i]['Variacion_Porcentual'];
                              echo "%";
                              echo "</td>";

                              if ($yourArray[$i]['Variacion_Porcentual'] < 0){
                                echo "<td>";
                                echo "<img class='flecha' src='../../avatares/flecharoja.svg'>";
                                echo "</td>";
                              }
                              if ($yourArray[$i]['Variacion_Porcentual'] > 0){
                                echo "<td>";
                                echo "<img class='flecha' src='../../avatares/flechaverde.svg'>";
                                echo "</td>";
                              }
                              if ($yourArray[$i]['Variacion_Porcentual'] == 0){

                                echo "<td>";
                                echo "<img class='flecha' src='../../avatares/flechanegra.svg'>";
                                echo "</td>";
                              }

                              echo "</tr>";
                              }
                              echo "</table>";

                              $mysqli->close();
                        ?>
                      </div>
                      <div class="column">
                        <?php
                                       // define('DB_HOST', 'localhost');
                                       // define('DB_USERNAME', 'maria');
                                       // define('DB_PASSWORD', 'maria');
                                       // define('DB_NAME', 'Corriente');

                                       $mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
                                       if(!$mysqli){
                                         die("Connection failed: " . $mysqli->error);
                                       }
                                       // Ranking de las oficinas
                                       $sqlmax="select max(oficina) from General;";
                                       $sqlcrear="select Oficina, Variacion_Porcentual from RankingOficina order by Variacion_Porcentual asc;";
                                       $res = $mysqli->query($sqlmax);
                                       $maximo = $res->fetch_assoc();
                                       $maximo = $maximo['max(oficina)'];
                                       $result = $mysqli->query($sqlcrear);

                                       $yourArray = array();

                                       $index = 0;
                                       while($row = $result->fetch_assoc()){
                                            $yourArray[$index] = $row;
                                            $index++;
                                       }
                                       $decimales=4;

                                       if ($maximo>4){
                                         $maximo=4;
                                       }
                                       // Creacion de las tablas de oficins
                                       echo "<table>";
                                       for($i=0;$i<$maximo;$i++){
                                       echo "<tr>";
                                       $variable=$yourArray[$i]['Oficina'];
                                       echo "<td>";
                                       echo '<svg xmlns="www.w3.org/2000/svg" viewBox="0 0 48 48"><path d="M40 36c2.21 0 3.98-1.79 3.98-4L44 10c0-2.21-1.79-4-4-4H8c-2.21 0-4 1.79-4 4v22c0 2.21 1.79 4 4 4H0c0 2.21 1.79 4 4 4h40c2.21 0 4-1.79 4-4h-8zM8 10h32v22H8V10zm16 28c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/></svg>';
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
                                       // Flechas para verificacion de aumento y descensos de consumo
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
                    </div>
                  </div>
                </section>

        <section class="aligncenter">
          <!--.wrap = container (width: 90%) with fadein animation -->
          <header>
            <!--.wrap or <nav> = container 1200px -->
            <div class="wrap">
              <h2>Consumos</h2>
              <p class="text-intro">Porcentajes dentro de la empresa.</p>
            </div>
          </header>
          <div class="wrap">
            <div class="grid">
              <div class="column">
                <canvas id="torta-equipos"></canvas>
              </div>
              <div class="column">
                <canvas id="torta-oficinas"></canvas>
              </div>
            </div>
              <!-- end .column -->
          </div>
          <!-- end .wrap -->
        </section>

      </article>
    </main>
    <!--main-->
    <!-- Required -->
    <script src="../static/js/webslides.js"></script>
    <script>
      window.ws = new WebSlides({ autoslide: 25000 });
    </script>
    <!-- OPTIONAL - svg-icons.js (fontastic.me - Font Awesome as svg icons) -->
    <script defer src="../static/js/svg-icons.js"></script>

  </body>
</html>
