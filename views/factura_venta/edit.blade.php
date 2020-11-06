@extends('adminlte::page')
@section('content')
<!-- Modal -->
@php
$nameuser = Auth::user()->name;
@endphp
<div class="container-fluid ">
    <form class="form-vertical" id="formulario" method="post">
        {{ csrf_field() }}
        <div class="form-row">
            <div class="card col-lg-9">
                <div class="card-header bg-gradient-lightblue">
                    <div class="row align-items-center">
                        <label class="col-8 mb-0 card-title">{{ __('Factura de Venta') }}</label>
                        <div class="col-md-2 col-xs-2" style="text-align: right;">
                            <a class="btn btn-danger" target="_blank" href="{{route('ventas.pdf',['id'=>$ventas->id])}}"><i class="fas fa-print"></i></a>
                        </div>
                        <div class="col-md-2 col-xs-2" style="text-align: right;">
                            <button class="btn btn-danger" type="button" onclick="anular({{$ventas->id}})"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>


                </div>
                <div class="card-body">

                    <input type="hidden" name="contador" id="contador" value="0">
                    <div class="form-group col-md-12 table-responsive">
                        <table class="table table-striped" id="agregaTable">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Descripción</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>IVA</th>
                                </tr>
                            </thead>
                            <tbody id="det_recibido">
                                @if(($ventas->detalle!=null))
                                    @foreach($ventas->detalle as $value)
                                        <tr>
                                            <td>{{$value->codigo}}</td>
                                            <td>{{$value->nombre}}</td>
                                            <td>{{$value->cantidad}}</td>
                                            <td>{{$value->precio}}</td>
                                            <td> @if(($value->iva)==1) SI @else NO @endif</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12" style="padding-top: 20px">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="col-md-12" style="padding: 8px">
                                    <div class="row">
                                        <label class="col-md-6">Subtotal</label>
                                        <b>@if(($ventas!=null)) @if(($ventas->iva_total>0)) {{$ventas->subtotal12}} @else {{$ventas->subtotal0}}  @endif @endif</b>
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 5px">
                                    <div class="row">
                                        <label class="col-md-6">Iva</label>
                                        <b>{{$ventas->iva_total}}</b>
                                        
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 5px">
                                    <div class="row">
                                        <label class="col-md-6">Total</label>
                                        <b>@if(($ventas!=null))  {{$ventas->total_final}} @endif</b>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class=" col-md-9">
                                &nbsp;
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card col-lg-3">
                <div class="card-header bg-gradient-lightblue">
                    <div class="row align-items-center">
                        <label class="col-6 card-title">{{ __('Datos de la Factura') }}</label>
                        <div class="col-md-6 col-xs-6" style="text-align: right;">
                           &nbsp;
                        </div>
                    </div>
                </div>
                <div class=" card-body">
                    <div class="form-row">
                        <div class="form-group col-sm-12 col-xs-12 col-md-12">
                            <label class="form-control-label" for="codigo">{{ __('Código de Venta:') }}</label>
                            <input type="text" class="form-control" name="codigo_pedido" id="codigo_pedido" value="{{$numero}}" readonly>
                        </div>
                        <div class="form-group col-12 col-xs-12 col-md-12">
                            <label class="form-control-label" for="codigo">{{ __('N° de Serie:') }}</label>
                            <input type="text" class="form-control" name="codigo_pedido" id="codigo_pedido" value="{{$numero}}" readonly>
                        </div>
                        <div class="form-group col-12 col-xs-12 col-md-12">
                            <label class="form-control-label" for="codigo">{{ __('Fecha de Pedido:') }}</label>
                            <input type="date" class="form-control" name="fecha" id="fecha" value="@if(($ventas!=null))  {{$ventas->fecha}} @endif" readonly>
                        </div>
                        <div class="form-group col-12 col-xs-12 col-md-12">
                            <label class="form-control-label" for="codigo">{{ __('Cliente:') }}</label>
                            <select class="form-control select2" name="id_cliente" id="id_cliente" disabled>
                                <option value="">Seleccione...</option>
                                @foreach($empleados as $value)
                                 <option  @if($ventas->id_cliente==$value->id) selected @endif value="{{$value->ci}}">{{$value->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-12 col-xs-12 col-md-12">
                            <label class="form-control-label" for="formas_pago">{{ __('Formas de Pago :') }}</label>
                            <select class="form-control select2" name="formas_pago" id="formas_pago" disabled>
                                <option value="">Seleccione...</option>
                                @foreach($formas_pago as $value)
                                 <option  @if($ventas->id_tipo==$value->id) selected @endif value="{{$value->id}}">{{$value->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-6 col-xs-6 col-md-12">
                            <label class="form-control-label" for="codigo">{{ __('Registrado por:') }}</label>
                            <input class="form-control" type="text" name="registrado" id="registrado" name="registrado" value="{{$nameuser}}" readonly>
                        </div>
                        <div class="form-group col-12 col-xs-12 col-md-12" id="addFormap">
                            <label for="Venta">Concepto:</label>
                            <input class="form-control" type="text" name="concepto" id="concepto" value="@if(($ventas!=null)) {{$ventas->observaciones}} @endif" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>
<script type="text/javascript">
    function print(){

    }
    function anular(id){
        const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success separator',
            cancelButton: 'btn btn-danger separator'
        },
        buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: '¿Deseas anular ésta factura?',
            text: "No puedes cerrar al instante!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: ' Si, anular! ',
            cancelButtonText: ' No',
            reverseButtons: true
            }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "{{route('ventas.anular')}}",
                    type:'get',
                    data: {
                    'id': id,
                    },
                    dataType: 'json',
                    success: function(data) {
                            console.log(data);
                            Swal.fire('Correcto!','Se anulo la factura de Venta','success');
                            window.setTimeout(function () {
                            location.href='{{route('ventas')}}';
                        }, 1000);

                    },
                    error: function(data) {
                       Swal.fire('Error',data,'error');

                    }
                });

            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                'Cancelado',
                '',
                'error'
                )
            }
        })
    }
</script>
@endsection
