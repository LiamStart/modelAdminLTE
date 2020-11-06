@extends('adminlte::page')
@section('content')
<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2020.3.915/styles/kendo.common.min.css" />
    <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2020.3.915/styles/kendo.blueopal.min.css" />

    <script src="https://kendo.cdn.telerik.com/2020.3.915/js/jquery.min.js"></script>
<div class="content-fluid">
    <div class="card">
        <div class="chart">
                   <!--<canvas id="areaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>-->
                    <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    <canvas style="display: none;" id="canvas"></canvas>
                    <div id="chart"></div>
        </div>
    </div>
</div>
<script src="https://kendo.cdn.telerik.com/2020.3.915/js/kendo.all.min.js"></script>
<script>
@php $cuenta2=0; $tipocontador=0; @endphp
function createChart() {
            $("#chart").kendoChart({
                title: {
                    text: "Radar Chart"
                },
                legend: {
                    position: "bottom"
                },
                seriesDefaults: {
                    type: "radarLine"
                },
                series: [
                  
                  {
                    name: "Mis Resultados",
                    data: [@foreach($verificar as $x) "{{$x->total}}", @endforeach]
                }],
                categoryAxis: {
                    categories: [@foreach($tipo_pregunta as $x)'{{$x->descripcion}}',@endforeach]
                },
                valueAxis: {
                    labels: {
                       
                    }
                },
                tooltip: {
                    visible: true,
                   
                }
            });
        }
$( document ).ready(function() {
  createChart()
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
   /* var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

    var areaChartData = {
    
      labels  : [@foreach($verificar as $vas)@php $d=DB::table('tipo_pregunta')->where('id',$vas->tipo)->first(); @endphp'{{$d->descripcion}}',@endforeach],

      datasets: [
        @foreach($verificar as $vas)@php $d=DB::table('tipo_pregunta')->where('id',$vas->tipo)->first(); @endphp
       

            {
            label               : '{{$d->descripcion}}',
            backgroundColor     : 'rgba(60,141,188,0.9)',
            borderColor         : 'rgba(60,141,188,0.8)',
            pointRadius          : false,
            pointColor          : '#3b8bba',
            pointStrokeColor    : 'rgba(60,141,188,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            
            data                : ['{{$vas->total}}',],
            
            },
        @endforeach
       
      ]

    }

    var areaChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          }
        }]
      }
    }

    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(areaChartCanvas, { 
      type: 'line',
      data: areaChartData, 
      options: areaChartOptions
    })*/

    //-------------
    //- LINE CHART -
    //--------------

    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.

    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData        = {
      labels: [@foreach($verificar as $vas)@php $d=DB::table('tipo_pregunta')->where('id',$vas->tipo)->first(); @endphp'{{$d->descripcion}}',@endforeach],
      datasets: [
        
        {
          data: [
            @foreach($verificar as $vas)
                '{{$vas->total}}',
            @endforeach
            ],
          backgroundColor : [@foreach($tipo_pregunta as $c) "{{$c->tipo_preguntacol}}", @endforeach],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
      
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var donutChart = new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions      
    })

    var color = Chart.helpers.color;
		var config = {
			type: 'radar',
			data: {
				labels: [@foreach($tipo_pregunta as $x)'{{$x->descripcion}}',@endforeach],
				datasets: [
                   
                    {
                  
					label: 'Preguntas',
					backgroundColor: '#f23122',
					borderColor:'#0000',
					pointBackgroundColor: '#f23122',
					data: [
                        @foreach($verificar as $vas)
                        "{{$vas->total}}",
                        @endforeach
                    ],
                    },
                    
				]
			},
			options: {
				legend: {
					position: 'top',
				},
				title: {
					display: true,
					text: 'Gráfico Radar'
				},
				scale: {
					ticks: {
						beginAtZero: false
					}
				}
			}
		};

		window.onload = function() {
			window.myRadar = new Chart(document.getElementById('canvas'), config);
		};
  })
  $(document).bind("kendo:skinChange", createChart);
 
</script>                
@endsection