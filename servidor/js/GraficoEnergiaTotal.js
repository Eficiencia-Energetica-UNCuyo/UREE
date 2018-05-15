

$.ajax({
	// Grafico de corriente por oficina.
	url : "../php/GraficoEnergiaTotal.php?",
	type : "GET",
	success : function(data){
		var acumulado = [];
		var DataDate = [];
		for(var i in data) {
			acumulado.push(data[i].Ventana_2);
			DataDate.push(data[i].DataDate);
		}

		// Objeto de configuracion de grafico de temperaturas.
		var chartdata = {
			labels: DataDate,
			datasets: [
				{
					label: "Temperatura",
					yAxisID:"Temperatura",
					fill: false,
					backgroundColor: "rgba(255,99,132,1)",
					borderColor: "rgba(255,99,132,1)",
					pointHoverBackgroundColor: "rgba(255,99,132,1)",
					pointHoverBorderColor: "rgba(255,99,132,1)",
					data: acumulado
				}
			]
		};
		// Generacion de graficos de temperatura
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
									id:"Temperatura",
									ticks: {
											fontColor: "rgba(59, 89, 152, 0.75)",
											fontStyle: "bold",
											callback: function(label, index, labels) {
																return label + '°C';
											}
									}
								}
							}]
					}
				}
		});
	},
	error : function(data) {} });
