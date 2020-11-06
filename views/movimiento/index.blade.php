@extends('adminlte::page')
@section('content')

<div class="container-fluid ">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Kardex Producto</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4 table-responsive">
                        <table id="example1" class="table table-bordered table-striped dataTable dtr-inline " role="grid" aria-describedby="example1_info">
                            <thead class="thead-light">
                                <tr>

                                    <th scope="col">Codigo</th>
                                    <th scope="col">Producto</th>
                                    <th scope="col">Observacion</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Creado Por:</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($movimiento as $value)
                                        <tr>

                                            <td>{{$value->codigo}}</td>
                                            <td>{{$value->producto->nombre}}</td>
                                            <td>{{$value->observacion}}</td>
                                            <td>{{$value->fecha}}</td>
                                            <td>{{$value->usuario->name}}</td>

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
