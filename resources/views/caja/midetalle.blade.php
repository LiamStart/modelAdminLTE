@extends('adminlte::page')
@section('content')
<style>
    .centerbu{
        text-align:center;
    }
</style>
<div class="modal fade" id="modaleditar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content" id="content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Gastos de Caja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="form_c" method="post">
                <div class="row">
                    <label class="col-md-6" for="">Monto:</label>
                    <input type="hidden" name="id_caja" id="id_caja" value="@if(!is_null($caja)){{$caja[0]->id_detalle_caja}}@endif">
                    <input type="text" class="form-control" name="monto" id="monto" onchange="redondear();" placeholder="$ 0.00" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
                    <label class="col-md-6" for="">Motivo:</label>
                    <textarea class="form-control" name="motivo" id="moitivo" cols="10" rows="3"></textarea>
                </div>
                </form>
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" onclick="guardar()" class="btn btn-primary">Guardar</button>
      </div>
            </div>
        </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-3">
                            <h3 class="mb-0">Resumen Caja</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('caja.create')}}" class="btn bg-gradient-primary"><i class="far fa-file"></i></a>
                        </div>
                        <div class="col-md-2 col-xs-2" style="text-align: left;">
                            <a class="btn btn-danger" target="_blank" href="{{route('caja.excel_caja',['id'=>$caja[0]->id_detalle_caja])}}"><i class="fas fa-print"></i></a>
                        </div>
                        <div class="col-md-2 col-xs-2" style="text-align: right;">
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modaleditar">
                                <i class="fas fa-minus"></i>
                            </button>

                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <table id="example1" class="table table-bordered table-striped dataTable dtr-inline" role="grid" aria-describedby="example1_info">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Fecha y Hora</th>
                                    <th scope="col">Descripcion</th>
                                    <th scope="col">Entrada ($)</th>
                                    <th scope="col">Salida ($)</th>
                                    <th scope="col">Saldo Actual</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                            
                                @foreach($caja as $values)
                                
                                        <tr>
                                            <td>{{$values->id}}</td>
                                            <td>{{$values->fecha}}</td>
                                            <td>{{$values->descripcion}}</td>
                                            <td>{{$values->ingreso}}</td>
                                            <td>{{$values->egreso}}</td>
                                            <td>@if(($values->egresos==0)) 0.00 @endif</td>

                                        </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
    $('#modaleditar').on('hidden.bs.modal', function(){
            $(this).removeData('bs.modal');
        });
        function redondear(){
           var monto= parseFloat($("#monto").val());
           if(!isNaN(monto)){
                $("#monto").val(monto.toFixed(2,2));
           }
        }
        function guardar(){
            $.ajax({
                type: 'post',
                url: "{{route('caja.guardflu')}}",
                headers: {
                    'X-CSRF-TOKEN': $('input[name=_token]').val()
                },
                datatype: 'json',
                data: $('#form_c').serialize(),
                success: function(data) {
                    console.log(data);
                    if(data=='ok'){
                        Swal.fire('Correcto', 'Se guardó correctamente.', 'success');
                        window.setTimeout(function () {
                                location.href='{{route('caja.midetallecaja')}}';
                            }, 1000);
                    }else{
                        Swal.fire('Advertencia', data, 'warning');
                    }
                    
                   
                
                   
                },
                error: function(data) {
                    Swal.fire('Error',data,'error');
                }
            })
        }
        
    </script>

@endsection
