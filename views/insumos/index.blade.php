@extends('adminlte::page')
@section('content')

<div class="container-fluid ">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Insumos</h3>
                        </div>
                        <div class="col-4 text-right">

                            <a href="{{route('insumos.create')}}" class="btn  btn-sm bg-gradient-primary">Agregar</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4 table-responsive">
                        <table id="example1" class="table table-bordered table-striped dataTable dtr-inline " role="grid" aria-describedby="example1_info">
                            <thead class="thead-light">
                                <tr>

                                    <th scope="col">Codigo</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Precio Venta</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Stock Minimo</th>
                                    <th scope="col">IVA</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Acción</th>
                                </tr>
                            </thead>
                            <tbody> 
                                
                                @foreach($producto as $value)
                                    @if(!is_null($value))                
                                        <tr>

                                            <td> @if(!is_null($value->codigo)) {{$value->codigo}} @endif</td>
                                            <td> @if(!is_null($value->nombre)){{$value->nombre}} @endif</td>
                                            <td>@if(!is_null($value->tipos)){{$value->tipos->nombre}} @endif</td>
                                            <td>{{$value->precio}}</td>
                                            <td>{{$value->precio_v}}</td>
                                            <td>{{$value->cantidad}}</td>
                                            <td>{{$value->stock_minimo}}</td>
                                            <td>@if(($value->iva==1)) SI @else NO @endif</td>
                                            <td>@if(($value->estado==1)) ACTIVO @else INACTIVO @endif</td>
                                            <td>
                                                <a class="btn btn-block btn-sm btn-warning" href="{{route('producto.edit',['id'=>$value->codigo])}}"><i class="far fa-fw fa-edit"></i></a>
                                                <a class="btn btn-block btn-sm btn-warning" target="_blank" href="{{route('producto.barras',['id'=>$value->codigo])}}"><i class="fas fa-barcode"></i></a>
                                            </td>
                                        </tr>
                                    @endif    
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
        </div>
    </div>

@endsection
