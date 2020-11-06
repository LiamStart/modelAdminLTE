@extends('adminlte::page')
@section('content')
    <div class="container-fluid">

            <div class="card">
                <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="col-12 mb-0">{{ __('Editar Usuario') }}</h3>
                        </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('caja.update',['id'=>$caja->id]) }}" autocomplete="off" id="formulario">
                    @csrf
                        @if (session('status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                        @endif
                        <div class="form-group{{ $errors->has('nro_caja') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="input-nro_caja">{{ __('N° Caja') }}</label>
                            <input type="text" name="nro_caja" id="input-nro_caja" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" class="form-control form-control-alternative{{ $errors->has('nro_caja') ? ' is-invalid' : '' }}" placeholder="{{ __('Nro Caja') }}" value="@if(($caja->nro_caja)!=null){{$caja->nro_caja}} @endif"  required autofocus>

                            @if ($errors->has('nro_caja'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('nro_caja') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('nombre') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="input-nombre">{{ __('Nombre') }}</label>
                            <input type="text" name="nombre" id="input-nombre" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" value="@if(($caja->nombre)!=null){{$caja->nombre}} @endif" placeholder="{{ __('Nombre') }}"  required autofocus>

                            @if ($errors->has('nombre'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('nombre') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('nombre_encargado') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="input-nombre_encargado">{{ __('Nombre Encargado') }}</label>
                            <input type="text" name="nombre_encargado" id="input-nombre_encargado" class="form-control form-control-alternative{{ $errors->has('nombre_encargado') ? ' is-invalid' : '' }}" placeholder="{{ __('Nombre Encargado') }}" value="@if(($caja->nombre_encargado)!=null){{$caja->nombre_encargado}} @endif"  required autofocus>

                            @if ($errors->has('nombre_encargado'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('nombre_encargado') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('estado') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Estado') }}</label>
                                    <select class="form-control" name="estado" id="estado">
                                        <option value="1">ACTIVO</option>
                                        <option value="0">INACTIVO</option>
                                    </select>
                        </div>

                        <div class="col-md-12" style="text-align: center">
                            <button type="submit" class="btn btn-success">Actualizar</button>
                        </div>
                    </form>
                </div>

            </div>

    </div>
@endsection
