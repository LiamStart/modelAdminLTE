@extends('adminlte::page')
@section('content')
    <div class="container-fluid">

            <div class="card">
                <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="col-12 mb-0">{{ __('Editar Proveedor') }}</h3>
                        </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('proveedor.update',['id'=>$cliente->ci]) }}" autocomplete="off" id="formulario">
                    @csrf
                    @if (session('status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                        @endif
                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="cedula">{{ __('Cédula Cliente:') }}</label>
                                    <input type="text" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" name="cedula" id="cedula" class="form-control form-control-alternative{{ $errors->has('ci') ? ' is-invalid' : '' }}" maxlength="13" placeholder="{{ __('Ci') }}" value="@if(($cliente->ci)!=null) {{$cliente->ci}} @endif"  required autofocus>

                                    @if ($errors->has('ci'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('ci') }}</strong>
                                        </span>
                                    @endif
                        </div>
                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="input-name">{{ __('Nombre Cliente:') }}</label>
                            <input type="text" name="nombre" id="input-nombre" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" value="@if(($cliente->ci)!=null) {{$cliente->ci}} @endif" placeholder="{{ __('Nombre') }}"  required autofocus>

                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="cedula">{{ __('Dirección de Cliente:') }}</label>
                                    <input type="text"  id="direccion" name="direccion" class="form-control form-control-alternative{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" value="@if(($cliente->direccion)!=null) {{$cliente->direccion}} @endif" placeholder="{{ __('Dirección de Cliente') }}"  required autofocus>

                                    @if ($errors->has('ci'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('ci') }}</strong>
                                        </span>
                                    @endif
                        </div>
                        <div class="form-group{{ $errors->has('telefono') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="telefono">{{ __('Telefono de Cliente:') }}</label>
                                    <input type="text" name="telefono" value="@if(($cliente->telefono)!=null) {{$cliente->telefono}} @endif" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"  id="telefono" class="form-control form-control-alternative{{ $errors->has('f_nacimiento') ? ' is-invalid' : '' }}"  autofocus>

                                    @if ($errors->has('telefono'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('telefono') }}</strong>
                                        </span>
                                    @endif
                        </div>
                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="email">{{ __('Email') }}</label>
                                    <input type="email" name="email" value="@if(($cliente->email)!=null) {{$cliente->email}} @endif" id="email" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}"  required autofocus>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
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
