function mail(){
  window.prompt("Dudas, consultas o sugerencias escribinos a:", "eficienciaenergeticauncuyo@gmail.com");
};
$(function() {
  AOS.init();
  $("#titu1").arctext({radius: 400});
  var i =0;
  var images = ['imagenes/Fondo1.jpg','imagenes/Fondo2.jpg','imagenes/Fondo3.jpg','imagenes/Fondo4.jpg','imagenes/Fondo5.jpg','imagenes/Fondo6.jpg','imagenes/Fondo7.jpg','imagenes/Fondo8.jpg','imagenes/Fondo9.jpg','imagenes/Fondo10.jpg','imagenes/Fondo11.jpg'];
  var image = $('#slideit');
                //Initial Background image setup
  image.css('background-image', 'url(imagenes/Fondo4.jpg)');
                //Change image at regular intervals
  setInterval(function(){
   image.fadeOut(250, function () {
   image.css('background-image', 'url(' + images [i++] +')');
   image.fadeIn(750);
   });
   if(i == images.length)
    i = 0;
  }, 15000);

  //smooth scroolling to anchors

  $("a").on('click', function(event) {
    if (this.hash !== "") {
      event.preventDefault();
      // Store hash
      var hash = this.hash;
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 800, function(){
        // Add hash (#) to URL when done scrolling (default click behavior)
        window.location.hash = hash;
      });
    }
  });

  //graficosssssss
 for (var i = 0; i < 2; i++) {
   if (i==1) {
     var ctx = document.getElementById("myChart2");
   }else {
     var ctx = document.getElementById("myChart3");
   }
  var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: ["Esperando a recibir datos"],
          datasets: [{
              label: "¿Que desea ver?",
              data: [0],
              backgroundColor: [
                  'rgba(255,99,132,1)'
              ],
              borderColor: [
                  'rgba(255,99,132,1)'
              ],
              borderWidth: 1
          }]
      },
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero:true
                  }
              }]
          }
      }
  });
};

  /*var CSStransforms = anime({
  targets: '.circular',
  translateX: 530,
  translateY: -35,
  elasticity: 300,
  rotate: '2turn',
  easing: 'easeInOutBack'
});*/
  function range(start, stop, step){
  var a=[start], b=start;
  while(b<stop){b+=step;a.push(b)}
  return a;
};
});
function expand() {
  //var num = expansible.toString();
  //var ID ="#rango" + expansible;
  document.getElementById("rango3").classList.add('expandido');
  document.getElementById("rango3").classList.remove('circular');
};
function contraer() {
  //var num = expansible.toString();
  //var ID ="#rango" + expansible;
  document.getElementById("rango3").classList.remove('expandido');
  document.getElementById("rango3").classList.add('circular');
}
function expand2() {
  //var num = expansible.toString();
  //var ID ="#rango" + expansible;
  document.getElementById("rango2").classList.add('expandido');
  document.getElementById("rango2").classList.remove('circular');
};
function contraer2() {
  //var num = expansible.toString();
  //var ID ="#rango" + expansible;
  document.getElementById("rango2").classList.remove('expandido');
  document.getElementById("rango2").classList.add('circular');
}
