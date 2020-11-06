@extends('adminlte::page')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Lista de Cajas</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('caja.asignacion')}}" class="btn btn-sm bg-gradient-primary">Asignación Caja</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <table id="example1" class="table table-bordered table-striped dataTable dtr-inline" role="grid" aria-describedby="example1_info">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Usuario</th>
                                    <th scope="col">Fecha Apertura</th>
                                    <th scope="col">Fecha Cierre</th>
                                    <th scope="col">Ventas</th>
                                    <th scope="col">Monto Inicial</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($caja as $value)
                                        <tr>
                                            <td>{{$value->usuario->name}}</td>
                                            <td>{{$value->fechaini}}</td>
                                            <td>@if(!is_null($value->fechafin)){{$value->fechafin}} @endif</td>
                                            <td>@if(!is_null($value->ventas)){{$value->ventas}} @endif</td>
                                            <td>{{$value->montoini}}</td>
                                            <td>@if(!is_null($value->montofin)){{$value->montofin}} @endif</td>
                                             
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
