//$(document).ready(function(){
$( function() {
	$( "#ini" ).datepicker({dateFormat: "yy-mm-dd",
	showAnim: "drop",
	//showButtonPanel: true,
	showOtherMonths: true,
	selectOtherMonths: true,
	monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre","Octubre", "Noviembre", "Diciembre" ],
	dayNamesMin: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
	prevText: "&lt;",
	nextText: "&gt;"
});
$( "#fini" ).datepicker({dateFormat: "yy-mm-dd",
showAnim: "drop",
//showButtonPanel: true,
showOtherMonths: true,
selectOtherMonths: true,
monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre","Octubre", "Noviembre", "Diciembre" ],
dayNamesMin: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
prevText: "&lt;",
nextText: "&gt;"
});

});

function promedio(val) {
	var str = document.getElementById("oli").value;
	var ini = document.getElementById("ini").value;
	var fini = document.getElementById("fini").value;
$.ajax({
	url : "../php/promedios.php?q=" +str+"&ini=" +ini+"&fini=" +fini+"&val=" +val,
	type : "GET",
	success : function(data){
		console.log(data);

		var average = [];
		for(var i in data) {
			average.push(data[i].avg_mileage);
		}
		document.getElementById("prom").innerHTML = average[0];
	}
});}
	function holanda(){
		var str = document.getElementById("oli").value;
		var ini = document.getElementById("ini").value;
		var fini = document.getElementById("fini").value;
	$.ajax({
		url : "../php/GraficoFinal.php?q=" +str+"&ini=" +ini+"&fini=" +fini,
		type : "GET",
		success : function(data){
			console.log(data);

			var ID = [];
			var Temperatura = [];
			var Humedad = [];
			var Pir = [];
			var Ventana_1 = [];
			var Ventana_2 = [];
			var DataDate = [];

			for(var i in data) {
				ID.push(data[i].id);
				Temperatura.push(data[i].Temp);
				Humedad.push(data[i].Hum);
				Pir.push(data[i].Pir);
				Ventana_1.push(data[i].Ventana_1);
				Ventana_2.push(data[i].Ventana_2);
				DataDate.push(data[i].DateDate);
			}


			var chartdata = {
				labels: ID,
				datasets: [
					{
						label: "Temp",
						fill: false,
						lineTension: 0.1,
						backgroundColor: "rgba(59, 89, 152, 0.75)",
						borderColor: "rgba(59, 89, 152, 1)",
						pointHoverBackgroundColor: "rgba(59, 89, 152, 1)",
						pointHoverBorderColor: "rgba(59, 89, 152, 1)",
						data: Temperatura
					},
					{
						label: "Hum",
						fill: false,
						lineTension: 0.1,
						backgroundColor: "rgba(29, 202, 255, 0.75)",
						borderColor: "rgba(29, 202, 255, 1)",
						pointHoverBackgroundColor: "rgba(29, 202, 255, 1)",
						pointHoverBorderColor: "rgba(29, 202, 255, 1)",
						data: Humedad
					}

				]
			};

			var ctx = $("#mycanvas");

			var LineGraph = new Chart(ctx, {
				type: 'line',
				data: chartdata
			});
		},
		error : function(data) {} }); }
