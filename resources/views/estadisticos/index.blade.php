@extends('adminlte::page')
@section('content')
<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2020.3.915/styles/kendo.common.min.css" />
    <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2020.3.915/styles/kendo.blueopal.min.css" />

    <script src="https://kendo.cdn.telerik.com/2020.3.915/js/jquery.min.js"></script>
<div class="content-fluid">
    <form method="POST" id="formul">
      @csrf
        <div class="row">
          <div class="col-md-3 form-group">
            <label for="">Fecha Desde</label>
            <input class="form-control" type="date" name="desde" id="desde" value="{{date('Y-m-d')}}">
          </div>
          <div class="col-md-3 form-group">
          <label for="">Fecha Hasta</label>
            <input class="form-control" type="date" name="hasta" id="hasta" value="{{date('Y-m-d')}}">
          </div>
          <div class="col-md-3 form-group">
            <label for="">Estudiante</label>
            <select name="id_estudiante" id="id_estudiante" class="form-control select2">
              <option value="">Seleccione...</option>
                @foreach($estudiantes as $value)
                  <option @if(($id_us)==$value->id) selected="selected" @endif value="{{$value->id}}">{{$value->name}}</option>
                @endforeach
            </select>
          </div>
          <div class="col-md-3 form-group">
              <label class="col-md-12" for="">&nbsp;</label>
              <button type="button" onclick="sum() " class="btn btn-success">Buscar</button>
          </div>
        </div>
       
    </form>
    <div class="card">
        <div class="chart">
                   <!--<canvas id="areaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>-->
                   <div class="row">
                   <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    <canvas style="display: none;" id="canvas"></canvas>
                    <div id="chart"></div>
                   </div>

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
    function sum(){
      $( "#formul" ).submit();
    }
$( document ).ready(function() {
  createChart()
 
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