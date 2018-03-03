
$.ajax({
  url : "../php/geraisPieEquipos.php",
  type : "GET",
  success : function(data){
    console.log("GERAIS.JS");
    console.log('%O',{data});
    var equipo = [];
    var energia = [];
    var colores = [];
    for(var i in data) {
      equipo.push(data[i].equipo);
      energia.push(Math.round(data[i].energia));
    }
    console.log(equipo);
    console.log(energia);

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
    console.log(equipo);
    console.log(colores);
    var config = {
        data: {
            datasets: [{
                data: [
                  //porcentajes
                   energia[0]
                ],
                backgroundColor: [
                  colores[0]
                ],
                //label: 'Consumo porcentual' // for legend
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
            // scale: {
            //   ticks: {
            //     beginAtZero: true
            //   },
            //   reverse: false
            // },
            animation: {
                animateRotate: true,
                animateScale: true
            }
        }
    };
    var ctx = document.getElementById("torta-equipos");
    window.myPie = new Chart(ctx, config);

    j=1;
    for (var i = 1; i < equipo.length; i++) {
          //function() {
          if (config.data.datasets.length > 0) {
              config.data.labels.push(equipo[i]);
              config.data.datasets.forEach(function(dataset) {
              //var colorName = lista[j++];
              dataset.backgroundColor.push(lista[j++]);
              dataset.data.push(energia[i]);
              if (j==lista.length) {
                  j=0;
              }
              });
            }
          //}
        }
    window.myPie.update();
    //var myLineChart = new Chart(ctx,config)
  },error : function(data) {}
});
////////////////////////////////////////////////////////////////////////////////

$.ajax({
  url : "../php/polar.php",
  type : "GET",
  success : function(data){
    //console.log(data);
    var porcentajes = [];
    var oficinas = [];
    var colores = [];
    for(var i in data) {
      porcentajes.push(data[i]);
    }
    //console.log(data);
    console.log(porcentajes);
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
    console.log(oficinas);
    console.log(colores);
    var config = {
        data: {
            datasets: [{
                data: [
                  //porcentajes
                   porcentajes[0]
                ],
                backgroundColor: [
                  colores[0]
                ],
                //label: 'Consumo porcentual' // for legend
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
            scale: {
              ticks: {
                beginAtZero: true
              },
              reverse: false
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
          //function() {
          if (config.data.datasets.length > 0) {
              config.data.labels.push(oficinas[i]);
              config.data.datasets.forEach(function(dataset) {
              //var colorName = lista[j++];
              dataset.backgroundColor.push(lista[j++]);
              dataset.data.push(porcentajes[i]);
              if (j==lista.length) {
                  j=0;
              }
              });
            }
          //}
        }
    window.myPolarArea.update();
    //var myLineChart = new Chart(ctx,config)
  },error : function(data) {}
});
