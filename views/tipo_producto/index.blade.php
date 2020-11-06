@extends('adminlte::page')
@section('content')

<div class="container-fluid ">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Tipo Producto</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('tipo_producto.create')}}" class="btn  btn-sm bg-gradient-primary">Agregar</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <table id="example1" class="table table-bordered table-striped dataTable dtr-inline " role="grid" aria-describedby="example1_info">
                            <thead class="thead-light">
                                <tr>

                                    <th scope="col">Id</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tipo as $value)
                                        <tr>

                                            <td>{{$value->id}}</td>
                                            <td>{{$value->nombre}}</td>
                                            <td>@if(($value->estado==1)) ACTIVO @else INACTIVO @endif</td>
                                            <td>
                                                <a class="btn btn-block btn-sm btn-warning" href="{{route('tipo_producto.edit',['id'=>$value->id])}}"><i class="far fa-fw fa-edit"></i></a>
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

@endsection
