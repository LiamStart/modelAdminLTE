@extends('adminlte::page')
@section('content')
<style>
    .centerbu{
        text-align:center;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h3 class="mb-0">Resumen Caja</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('caja.create')}}" class="btn bg-gradient-primary"><i class="far fa-file"></i></a>
                        </div>
                        <div class="col-md-2 col-xs-2" style="text-align: left;">
                            <a class="btn btn-danger" target="_blank" href="{{route('caja.excel_caja2')}}"><i class="fas fa-print"></i></a>
                        </div>
                       
                        
                    </div>
                </div>

                <div class="card-body">
                    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <table id="example1" class="table table-bordered table-striped dataTable dtr-inline" role="grid" aria-describedby="example1_info">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Caja</th>
                                    <th scope="col">Usuario</th>
                                    <th scope="col">Ventas</th>
                                    <th scope="col">Fecha Inicio</th>
                                    <th scope="col">Fecha Cierre</th>
                                    <th scope="col">Monto Inicio</th>
                                    <th scope="col">Monto Fin</th>
                                    <th scope="col">Estado</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($caja as $value)
                                    
                                        <tr>
                                            <td>{{$value->id}}</td>
                                            <td>{{$value->caja->nombre}}</td>
                                            <td>{{$value->usuario->name}}</td>
                                            <td>@if(($value->ventas)!=null) {{$value->ventas}} @else 0 @endif</td>
                                            <td>@if(($value->fechaini)!=null){{$value->fechaini}} @endif</td>
                                            <td>@if(($value->fechafin)!=null){{$value->fechafin}} @else La caja aún no está cerrada @endif</td>
                                            <td>{{$value->montoini}}</td>
                                            <td>@if(($value->montofin)!=null) {{$value->montofin}} @else 0.00 @endif</td>
                                            <td @if(($value->montofin!=0)) bgcolor='#ef5350' @else bgcolor='#42A5F5' @endif  > @if(($value->montofin)!=0) <p style="text-align:center; color: white;"> CAJA CERRADA</p>  @else <p class="col-md-12" style="text-align:center; color: white;">CAJA ABIERTA</p> <div class="col-md-12 centerbu">
                                            </div>
                                             @endif </td>
                                            
                                        </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
