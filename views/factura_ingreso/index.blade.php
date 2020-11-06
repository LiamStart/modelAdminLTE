@extends('adminlte::page')
@section('content')

<div class="container-fluid ">
<div class="modal fade" id="modaleditar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content" id="content">

            </div>
        </div>
</div>
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Pago de Nómina/h3>
                        </div>
                        <div class="col-md-4 col-xs-4" style="text-align: right;">
                                    <a class="btn btn-danger" target="_blank" href="{{route('factura_ingreso.excel_nomina')}}"><i class="fas fa-print"></i></a>
                        </div>
                        
                    </div>
                </div>
                <div class="card-body">
                    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4 table-responsive">
                        <table id="example1" class="table table-bordered table-striped dataTable dtr-inline " role="grid" aria-describedby="example1_info">
                            <thead class="thead-light">
                                <tr>

                                    <th scope="col">Id</th>
                                    <th scope="col">Observaciones</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Subtotal</th>
                                    <th scope="col">Iva</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($facturas as $value)
                                        <tr>

                                            <td>{{$value->id}}</td>
                                            <td>{{$value->observaciones}}</td>
                                            <td>{{$value->cliente->nombre}}</td>
                                            <td>{{$value->subtotal}}</td>
                                            <td>{{$value->iva_total}}</td>
                                            <td>{{$value->total_final}}</td>
                                            <td @if(($value->estado)==1) bgcolor='#e6ff4b' @elseif(($value->estado==2)) bgcolor='#92fc6b' @endif >@if(($value->estado==1)) PENDIENTE PAGO @elseif($value->estado==2) PAGADO @endif</td>
                                            <td>
                                               @if(($value->estado)==1) <a class="btn btn-block btn-sm btn-warning"  href="javascript:abrir({{$value->id}})"><i class="fas fa-info-circle"></i></a> @endif
                                            </td>
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
        function abrir(id){
            $.ajax({
                    type: "get",
                    url: "{{route('factura_ingreso.edit')}}",
                    data:{id:id},
                    datatype: "html",
                    success: function(datahtml, data){
                        //console.log(data);
                        $("#content").html(datahtml);
                        $("#modaleditar").modal("show");
                    },
                    error:  function(data){
                        Swal.fire('Error','Error al cargar','error');
                        console.log(data);
                    }
            });

        }

        $('#modaleditar').on('hidden.bs.modal', function(){
        $(this).removeData('bs.modal');
        });
    </script>
@endsection
