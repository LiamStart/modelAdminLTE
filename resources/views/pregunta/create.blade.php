@extends('adminlte::page')
@section('content')
    <div class="container-fluid">

            <div class="card">
                <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="col-8 mb-0">{{ __('Agregar Pregunta') }}</h3>
                            <div class="text-right" style="text-align: right;">
                                <button type="button" class="btn btn-danger" onclick="regresar()"> Regresar </button>
                            </div>
                        </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('pregunta.store') }}" autocomplete="off" id="formulario">
                        @csrf
                        @if (session('status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                        @endif
            
                        <div class="form-group{{ $errors->has('pregunta') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="input-pregunta">{{ __('Ingrese Pregunta:') }}</label>
                           
                            <textarea class="form-control" name="descripcion" id="descripcion" placeholder="Ingrese Pregunta" cols="4"  required rows="4"></textarea>
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('tipo') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="tipo">{{ __('Tipo:') }}</label>
                                    <select class="form-control select2" name="tipo" id="tipo">
                                        <option value="0">Seleccione...</option>
                                        @foreach($tipo as $value)
                                            <option value="{{$value->id}}">{{$value->descripcion}}</option>
                                        @endforeach

                                    </select>

                                    @if ($errors->has('tipo'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('tipo') }}</strong>
                                        </span>
                                    @endif
                        </div>
                        <input type="hidden" name="contador" id="contador" value="0">
                        <div class="col-md-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        
                                        <th>Opciones</th>
                                        <th>Check Respuesta</th>
                                        <th> 
                                        <button onclick="crea_td()" type="button" class="btn btn-primary btn-gray btn-xs" >
                                        <i class="fas fa-plus"></i>
                                        </button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="det_recibido">
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12" style="text-align: center">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>

            </div>

    </div>
    <script>
        $('.select2').select2({
                tags: false
             });
        function crea_td(contador) {

                id = document.getElementById('contador').value;
                var midiv = document.createElement("tr")
                midiv.setAttribute("id","dato"+id);
                midiv.innerHTML= '<td><input class="form-control input-sm" name="opciones' + id + '" class="opciones" id="opciones' + id + '"  /> <input type="hidden" id="visibilidad' + id + '" name="visibilidad' + id + '" value="1"></td>   <td> <input type="checkbox" id="res' + id + '" name="res' + id + '" onchange="checkiva(this)" value="0"> </td> <td><button id="eliminar' + id + '" type="button" onclick="javascript:eliminar_registro(' + id + ')" class="btn btn-danger btn-gray delete btn-xs"> <i class="far fa-fw fa-trash-alt"></i></button></td>';
                document.getElementById('det_recibido').append(midiv);
                id = parseInt(id);
                id = id + 1;
                document.getElementById('contador').value = id;
                $('.select2').select2({
                    tags: false
                });

        }
        function checkiva(checkboxElem){
                if (checkboxElem.checked) {
                    checkboxElem.value="1";
                } else {
                    checkboxElem.value="0";
                }

        }
        function eliminar_registro(valor)
        {
            var dato1 = "dato"+valor;
            var nombre2 = 'visibilidad'+valor;
            document.getElementById(nombre2).value = 0;
            document.getElementById(dato1).style.display='none';
           
        }
        function regresar(){
            location.href="{{route('pregunta')}}";
        }
    </script>
@endsection
