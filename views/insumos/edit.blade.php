@extends('adminlte::page')
@section('content')
    <div class="container-fluid">

            <div class="card">
                <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="col-12 mb-0">{{ __('Editar Producto') }}</h3>
                        </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('insumos.update',['id'=>$producto->codigo]) }}" autocomplete="off" id="formulario">
                    @csrf
                    @if (session('status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                        @endif
                        <div class="form-group{{ $errors->has('codigo') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="codigo">{{ __('Código:') }}</label>
                                    <input type="text" name="codigo" id="codigo" class="form-control form-control-alternative{{ $errors->has('ci') ? ' is-invalid' : '' }}" value="@if(($producto->codigo)!=null){{$producto->codigo}} @endif" placeholder="{{ __('Código') }}"  required autofocus>

                                    @if ($errors->has('codigo'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('codigo') }}</strong>
                                        </span>
                                    @endif
                        </div>
                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="input-name">{{ __('Nombre Producto:') }}</label>
                            <input type="text" name="nombre" id="input-nombre" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" value="@if(($producto->nombre)!=null){{$producto->nombre}} @endif" placeholder="{{ __('Nombre') }}"  required autofocus>

                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('tipo') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="tipo">{{ __('Tipo:') }}</label>
                                    <select class="form-control" name="tipo" id="tipo">
                                        <option value="0">Seleccione...</option>
                                        @foreach($tipo as $value)
                                         <option  @if($producto->id_tipo==$value->id) selected @endif value="{{$value->id}}">{{$value->nombre}}</option>
                                        @endforeach

                                    </select>

                                    @if ($errors->has('tipo'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('tipo') }}</strong>
                                        </span>
                                    @endif
                        </div>
                        <div class="form-group{{ $errors->has('precio') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="precio">{{ __('Precio de Compra:') }}</label>
                                    <input type="text"  id="precio" name="precio" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" class="form-control form-control-alternative{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" placeholder="{{ __('Precio Compra') }}" value="@if(($producto->precio)!=null){{$producto->precio}} @endif"  required autofocus>

                                    @if ($errors->has('precio'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('precio') }}</strong>
                                        </span>
                                    @endif
                        </div>
                        <div class="form-group{{ $errors->has('precio_v') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="precio_v">{{ __('Precio de Venta:') }}</label>
                                    <input type="text"  id="precio_v" name="precio_v" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" class="form-control form-control-alternative{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" value="@if(($producto->precio_v)!=null){{$producto->precio_v}} @endif" placeholder="{{ __('Precio Venta') }}"  required autofocus>

                                    @if ($errors->has('precio_v'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('precio_v') }}</strong>
                                        </span>
                                    @endif
                        </div>
                        <div class="form-group{{ $errors->has('cantidad') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="cantidad">{{ __('Cantidad:') }}</label>
                                    <input type="number" name="cantidad"  id="cantidad" value="@if(($producto->cantidad)!=null){{$producto->cantidad}} @endif" class="form-control form-control-alternative{{ $errors->has('f_nacimiento') ? ' is-invalid' : '' }}"  autofocus>

                                    @if ($errors->has('cantidad'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('cantidad') }}</strong>
                                        </span>
                                    @endif
                        </div>
                        <div class="form-group{{ $errors->has('stock_minimo') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="stock_minimo">{{ __('Stock Minimo:') }}</label>
                                    <input type="number" name="stock_minimo"  id="stock_minimo" value="@if(($producto->stock_minimo)!=null){{$producto->stock_minimo}} @endif" class="form-control form-control-alternative{{ $errors->has('f_nacimiento') ? ' is-invalid' : '' }}"  autofocus>

                                    @if ($errors->has('stock_minimo'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('stock_minimo') }}</strong>
                                        </span>
                                    @endif
                        </div>
                        <div class="form-group{{ $errors->has('iva') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="iva">{{ __('IVA:') }}</label>
                                    <select class="form-control" name="iva" id="iva">
                                        <option value="">Seleccione...</option>
                                        <option  @if($producto->id_tipo==$value->id) selected @endif value="0">NO</option>
                                        <option  @if($producto->id_tipo==$value->id) selected @endif value="1">SI</option>
                                    </select>

                                    @if ($errors->has('iva'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('iva') }}</strong>
                                        </span>
                                    @endif
                        </div>
                        <div class="col-md-12" style="text-align: center">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>

            </div>

    </div>
@endsection
