@extends('adminlte::page')
@section('content')

<div class="container-fluid ">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Empleados</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('empleados.create')}}" class="btn  btn-sm bg-gradient-primary">Agregar</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4 table-responsive">
                        <table id="example1" class="table table-bordered table-striped dataTable dtr-inline " role="grid" aria-describedby="example1_info">
                            <thead class="thead-light">
                                <tr>

                                    <th scope="col">Ci</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Telefono</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($empleados as $value)
                                        <tr>
                                        J2RFZpkeJyR^8L(m9F
                                        wpy&hI25m7G&XjUPAouko5QT

                                            <td>{{$value->ci}}</td>
                                            <td>{{$value->nombre}}</td>
                                            <td>{{$value->email}}</td>
                                            <td>{{$value->telefono}}</td>#
                                            <td>@if(($value->estado==1)) ACTIVO @else INACTIVO @endif</td>
                                            <td>
                                                <a class="btn btn-block btn-sm btn-warning" href="{{route('empleados.edit',['id'=>$value->ci])}}"><i class="far fa-fw fa-edit"></i></a>
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
