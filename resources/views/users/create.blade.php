@extends('adminlte::page')
@section('content')
    <div class="container-fluid">

            <div class="card">
                <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="col-12 mb-0">{{ __('Agregar Usuario') }}</h3>
                        </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('users.store') }}" autocomplete="off" id="formulario">
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
                            <label class="form-control-label" for="input-name">{{ __('Nombre') }}</label>
                            <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Nombre') }}"  required autofocus>

                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="email">{{ __('Email') }}</label>
                                    <input type="email" name="email" id="email" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}"  required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                        </div>
                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="cedula">{{ __('Ci') }}</label>
                                    <input type="text" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" name="cedula" id="cedula" class="form-control form-control-alternative{{ $errors->has('ci') ? ' is-invalid' : '' }}" placeholder="{{ __('Ci') }}"  required autofocus>

                                    @if ($errors->has('ci'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('ci') }}</strong>
                                        </span>
                                    @endif
                        </div>
                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="cedula">{{ __('Número de Telefono') }}</label>
                                    <input type="text" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" name="phone_number" id="phone_number" class="form-control form-control-alternative{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" placeholder="{{ __('No Telefono') }}"  required autofocus>

                                    @if ($errors->has('ci'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('ci') }}</strong>
                                        </span>
                                    @endif
                        </div>
                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="f_nacimiento">{{ __('Fecha Nacimiento') }}</label>
                                    <input type="date" name="f_nacimiento" id="f_nacimiento" class="form-control form-control-alternative{{ $errors->has('f_nacimiento') ? ' is-invalid' : '' }}"   required autofocus>

                                    @if ($errors->has('f_nacimiento'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('f_nacimiento') }}</strong>
                                        </span>
                                    @endif
                        </div>
                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Tipo Usuario') }}</label>
                                    <select class="form-control" name="tipo_usuario" id="tipo_usuario">
                                        <option value="0">Seleccione...</option>
                                        @foreach($type_user as $value)
                                            <option  value="{{$value->id}}">{{$value->nombre}}</option>
                                        @endforeach
                                    </select>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-current-password">{{ __('Password') }}</label>
                                    <input type="password" name="password" id="input-current-password" class="form-control form-control-alternative{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Actual Password') }}" value="" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                        </div>
                        <div class="col-md-12" style="text-align: center">
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </div>
                    </form>
                </div>

            </div>

    </div>
@endsection
