@extends('adminlte::page')
@section('content')

<div class="container-fluid ">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Mis test</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4 table-responsive">
                        <table id="example1" class="table table-bordered table-striped dataTable dtr-inline " role="grid" aria-describedby="example1_info">
                            <thead class="thead-light">
                                <tr>

                                    <th scope="col">Id</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pregunta as $value)
                                    
                                        <tr>
                                            <td>{{$value->id}}</td>
                                            <td>{{$value->nombre}}</td>
                                            <td>{{$value->created_at}}</td>
                                            <td>@if(($value->estado==1)) ACTIVO @else INACTIVO @endif</td>
 
                                            <td>
                                                <a class="btn btn-block btn-sm btn-primary" href="{{route('mitest.observar',['id'=>$value->id])}}"><i class="far fa-eye"></i></a>
                                                <a class="btn btn-block btn-sm btn-primary" href="{{route('mitest.estadisticos',['id'=>$value->id])}}"><i class="fas fa-chart-pie"></i></a>
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
