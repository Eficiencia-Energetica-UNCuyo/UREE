$( function() {
	// Generacion del calendario
	$( ".datepicker" ).datepicker({dateFormat: "yy-mm-dd",
	showAnim: "drop",
	showOtherMonths: true,
	selectOtherMonths: true,
	monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre","Octubre", "Noviembre", "Diciembre" ],
	dayNamesMin: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
	prevText: "&lt;",
	nextText: "&gt;"
	});
});


function holanda(){
	contraer();
	// Creacion de formulario.
	var str = document.getElementById("oli").value;
	var ini = document.getElementById("ini").value;
	var fini = document.getElementById("fini").value;
$.ajax({
	url : "../php/GraficoFinal.php?q=" +str+"&ini=" +ini+"&fini=" +fini,
	type : "GET",

	success : function(data) {
		//Adquisicion de datos.
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
			DataDate.push(data[i].DataDate);
		}

		var puntos = 25;
		var n = Math.floor(DataDate.length/puntos);
		var DataDateredux = new Array();
		for (i = 0; i < puntos; i++) {
		  	DataDateredux[i] = DataDate[i*n];
		};
		// Grafico de temperaturas por oficina
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
					cubicInterpolationMode: 'monotone',
					pointRadius: 0.2,
					pointHoverBorderColor: "rgba(255,99,132,1)",
					data: Temperatura
				},
				{
					label: "Humedad",
					yAxisID:"Humedad",
					fill: false,
					backgroundColor: "rgba(54, 162, 235, 1)",
					borderColor: "rgba(54, 162, 235, 1)",
					pointRadius: 0.2,
					cubicInterpolationMode: 'monotone',
					pointHoverBackgroundColor: "rgba(54, 162, 235, 1)",
					pointHoverBorderColor: "rgba(54, 162, 235, 1)",
					data: Humedad
				}
			]
		};

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
											autoSkip: true,
											maxTicksLimit: 5
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
																return label+'°C';
											}
									}
								},{
										position:"right",
										type: "linear",
										id:"Humedad",
										ticks: {
												fontColor: "rgba(29, 202, 255, 0.75)",
												fontStyle: "bold",
												callback: function(label, index, labels) {
																	return label+'%';

												}
										}
							}]
					}
				}
		});
	},
	error : function(data) {} }); }
		// Graficos de energia por individuo
		function holandacorriente(){
			contraer2();
			var str = document.getElementById("oli_corriente").value;
			str = str.replace(" ","_");
			console.log(str);
			var ini = document.getElementById("ini_corriente").value;
			var fini = document.getElementById("fini_corriente").value;
		$.ajax({
			url : "../php/GraficoCorrienteFinal.php?nombre=" + str + "&ini=" + ini + "&fini=" + fini,
			type : "GET",
			success : function(data){

				var energia = [];
				var DataDate = [];
				for(var i in data) {
					energia.push(data[i].energia);
					DataDate.push(data[i].DataDate);
				}

				var puntos = 17;
				var n = Math.floor(DataDate.length/puntos);
				var DataDateredux = new Array();
				for (i = 0; i < puntos; i++) {
				  	DataDateredux[i] = DataDate[i*n];
				};

				var ctx2 = $("#myChart2");

				var myLineChart = new Chart(ctx2, {
				    type: 'line',
				    data: {
                labels: DataDate,
                datasets: [{
                    label: "Energía",
                    backgroundColor: "rgba(54, 162, 235, 0.8)",
                    borderColor: "rgba(54, 162, 235, 0)",
										pointRadius: 0.1,
                    data: energia,
                    fill: 'origin',
                }]
            },
				    options: {
                responsive: true,
                title:{
                    display:true,
                    text:'Consumo Energético'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
												showXLabels: 5,
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Tiempo'
                        },
												ticks: {
														maxRotation: 0,
														minRotation: 0,
														fontColor: "#9a9ca5",
														fontStyle: "bold",
														maxTicksLimit: 5
												}
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Energía'
                        },
												ticks: {
													fontColor: "#9a9ca5",
													fontStyle: "bold",
														callback: function(label, index, labels) {
																			return label+' kWh';
														}
												}
                    }]
                }
            }
				});
			},error : function(data) {}
		});
	}

				$.ajax({
					// Obtencion de datos del grafico polar y graficacion
					url : "../php/polar.php",
					type : "GET",
					success : function(data){
						console.log(data);
						var porcentajes = [];
						var oficinas = [];
						var colores = [];
						for(var i in data) {
							porcentajes.push(data[i]);
						}

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
								type: 'polarArea',
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
						var ctx = document.getElementById("polar_1");
						window.myPolarArea = Chart.PolarArea(ctx, config);

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
