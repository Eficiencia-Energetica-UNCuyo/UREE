
$.ajax({
  url : "../php/geraisPieEquipos.php",
  type : "GET",
  success : function(data){
    // Grafico de tortas para el consumo energetico
    var equipo = [];
    var energia = [];
    var colores = [];
    for(var i in data) {
      equipo.push(data[i].equipo);
      energia.push(Math.round(data[i].energia));
    }

    var lista = [
            "rgba(54, 162, 235, 0.5)",
            "rgba(255, 205, 86, 0.5)",
            "rgba(75, 192, 192, 0.5)",
            "rgba(255, 99, 132, 0.5)",
            "rgba(153, 102, 255, 0.5)",
            "rgba(201, 203, 207, 0.5)"
          ];
    var j = 0;
    for (var i = 0; i < equipo.length; i++) {
      colores[i] = lista[j++];
      if (j==lista.length) {
        j=0;
      }
    }
    var config = {
        data: {
            datasets: [{
                data: [
                   energia[0]
                ],
                backgroundColor: [
                  colores[0]
                ],
            }],
            labels: [
                equipo[0]
            ]
        },
        type: 'pie',
        options: {
            responsive: true,
            legend: {
                position: 'right',
            },
            title: {
                display: true,
                text: 'Distribución de Consumos %'
            },

            animation: {
                animateRotate: true,
                animateScale: true
            }
        }
    };
    var ctx = document.getElementById("torta-equipos");
    window.myPie = new Chart(ctx, config);

    j=1;
    // Mapeo de colores para grafico de torta
    for (var i = 1; i < equipo.length; i++) {
          if (config.data.datasets.length > 0) {
              config.data.labels.push(equipo[i]);
              config.data.datasets.forEach(function(dataset) {
              dataset.backgroundColor.push(lista[j++]);
              dataset.data.push(energia[i]);
              if (j==lista.length) {
                  j=0;
              }
              });
            }
        }
    window.myPie.update();
  },error : function(data) {}
});

$.ajax({

  // Grafico polar para consumo por oficina
  url : "../php/polar.php",
  type : "GET",
  success : function(data){
    var porcentajes = [];
    var oficinas = [];
    var colores = [];
    for(var i in data) {
      porcentajes.push(data[i]);
    }
    var lista = [
            "rgba(54, 162, 235, 0.5)",
            "rgba(255, 205, 86, 0.5)",
            "rgba(75, 192, 192, 0.5)",
            "rgba(255, 99, 132, 0.5)",
            "rgba(153, 102, 255, 0.5)",
            "rgba(201, 203, 207, 0.5)"
          ];
    var j = 0;
    for (var i = 0; i < porcentajes.length; i++) {
      oficinas[i] = "Oficina " + (i+1).toString();
      colores[i] = lista[j++];
      if (j==lista.length) {
        j=0;
      }
    }
    var config = {
        data: {
            datasets: [{
                data: [
                   porcentajes[0]
                ],
                backgroundColor: [
                  colores[0]
                ],
            }],
            labels: [
                oficinas[0]
            ]
        },
        type: 'pie',
        options: {
            responsive: true,
            legend: {
                position: 'right',
            },
            title: {
                display: true,
                text: 'Distribución de Consumos %'
            },
            animation: {
                animateRotate: true,
                animateScale: true
            }
        }
    };
    var ctx = document.getElementById("torta-oficinas");
    window.myPolarArea = new Chart(ctx, config);

    j=1;
    for (var i = 1; i < porcentajes.length; i++) {
          if (config.data.datasets.length > 0) {
              config.data.labels.push(oficinas[i]);
              config.data.datasets.forEach(function(dataset) {
              dataset.backgroundColor.push(lista[j++]);
              dataset.data.push(porcentajes[i]);
              if (j==lista.length) {
                  j=0;
              }
              });
            }
        }
    window.myPolarArea.update();
  },error : function(data) {}
});
