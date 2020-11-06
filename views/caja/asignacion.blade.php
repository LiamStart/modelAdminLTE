@extends('adminlte::page')
@section('content')
    <div class="container-fluid">

            <div class="card">
                <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="col-12 mb-0">{{ __('Asignacion Caja Diaria') }}</h3>
                        </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('caja.asiganarstore') }}" autocomplete="off" id="formulario">
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
                            <label class="form-control-label" for="input-nro_caja">{{ __('Caja Nº ') }}</label>
                            <select name="id_caja" id="id_caja" class="form-control select2" required>
                                <option value="">Seleccione...</option>
                                @foreach($caja as $value)
                                    <option value="{{$value->id}}">{{$value->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group{{ $errors->has('nombre') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="input-name">{{ __('Nombre') }}</label>
                            <select name="id_usuario" id="id_usuario" class="form-control select2" required>
                                <option value="">Seleccione...</option>
                                @foreach($usuario as $value)
                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group{{ $errors->has('nombre_encargado') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="input-valor">{{ __('Valor de caja') }}</label>
                            <input class="form-control" type="text" name="valor" id="valor"  onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" requred>
                        </div>

                        <div class="col-md-12" style="text-align: center">
                            <button type="button" class="btn  btn-success" onclick="guardar()">Guardar</button>
                        </div>
                    </form>
                </div>

            </div>

    </div>
    <script>
        $('.select2').select2({
        tags: false
         });
         function guardar() {
                var formulario = document.forms["formulario"];
                var id_caja = formulario.id_caja.value;
                var id_usuario = formulario.id_usuario.value;
                var msj = "";
                if (id_caja == "") {
                    msj += "Por favor, llene los datos correctamente. <br/>";
                }
                if (id_usuario == "") {
                    msj += "Por favor, Llene el campo empleado <br/>";
                }
                var fecha= new Date();
                var hora= fecha.getHours();
                var minutos= fecha.getMinutes();
                var dia= fecha.getDate();
                if (msj == "") {
                    //alert("entras");
                    $.ajax({
                        type: 'post',
                        url: "{{route('caja.asiganarstore')}}",
                        headers: {
                            'X-CSRF-TOKEN': $('input[name=_token]').val()
                        },
                        datatype: 'html',
                        data: $('#formulario').serialize(),
                        success: function(datahtml, data){
                            //console.log(data);
                        Swal.fire({
                            title: "¡Correcto!", 
                            html: datahtml,  
                            confirmButtonText: "Aceptar", 
                        });
                        window.setTimeout(function () {
                                location.href='{{route('caja.asignacion')}}';
                            }, 1000);
                        },
                        error: function(data) {
                            Swal.fire('Error',data,'error');
                        }
                    })
                } else {
                    Swal.fire({
                        title: "Error!",
                        icon: 'error',
                        type: "error",
                        html: msj
                    });
                }
         }
    </script>
@endsection
