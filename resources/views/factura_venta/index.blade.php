@extends('adminlte::page')
@section('content')

<div class="container-fluid ">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Facturas de Venta</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('ventas.create')}}" class="btn  btn-sm bg-gradient-primary">Nuevo</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="example1_wrapper" class="table table-responsive">
                        <table id="example1" class="table table-bordered table-striped dataTable dtr-inline " role="grid" aria-describedby="example1_info">
                            <thead class="thead-light">
                                <tr>

                                    <th scope="col">N°</th>
                                    <th scope="col">Observaciones</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Subtotal</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ventas as $value)
                                        <tr>

                                            <td>{{$value->id}}</td>
                                            <td>{{$value->observaciones}}</td>
                                            <td>@if(!is_null($value->cliente)){{$value->cliente->nombre}} @endif</td>
                                            <td>{{$value->fecha}}</td>
                                            <td>@if(($value->subtotal>0)){{$value->subtotal0}} @else {{$value->subtotal12}} @endif</td>
                                            <td>{{$value->total_final}}</td>
                                            <td>@if(($value->estado==1)) ACTIVO @else INACTIVO @endif</td>
                                            <td>
                                                <a class="btn btn-block btn-sm btn-warning" href="{{route('ventas.edit',['id'=>$value->id])}}"><i class="far fa-fw fa-edit"></i></a>
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
