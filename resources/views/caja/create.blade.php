@extends('adminlte::page')
@section('content')
    <div class="container-fluid">

            <div class="card">
                <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="col-12 mb-0">{{ __('Agregar Caja') }}</h3>
                        </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('caja.store') }}" autocomplete="off" id="formulario">
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
                            <input type="text" name="nro_caja" id="input-nro_caja" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" class="form-control form-control-alternative{{ $errors->has('nro_caja') ? ' is-invalid' : '' }}" placeholder="{{ __('Nro Caja') }}"  required autofocus>

                            @if ($errors->has('nro_caja'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('nro_caja') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('nombre') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="input-name">{{ __('Nombre') }}</label>
                            <input type="text" name="nombre" id="input-nombre" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Nombre') }}"  required autofocus>

                            @if ($errors->has('nombre'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('nombre') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('nombre_encargado') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="input-nombre_encargado">{{ __('Nombre Encargado') }}</label>
                            <input type="text" name="nombre_encargado" id="input-nombre_encargado" class="form-control form-control-alternative{{ $errors->has('nombre_encargado') ? ' is-invalid' : '' }}" placeholder="{{ __('Nombre Encargado') }}"  required autofocus>

                            @if ($errors->has('nombre_encargado'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('nombre_encargado') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('estado') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Estado') }}</label>
                                    <select class="form-control" name="estado" id="estado">
                                        <option value="">Seleccione...</option>
                                        <option value="1">ACTIVO</option>
                                        <option value="0">INACTIVO</option>
                                    </select>
                        </div>

                        <div class="col-md-12" style="text-align: center">
                            <button type="submit" class="btn  btn-success">Guardar</button>
                        </div>
                    </form>
                </div>

            </div>

    </div>
@endsection
