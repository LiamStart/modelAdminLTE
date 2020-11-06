@extends('adminlte::page')
@section('content')
     @php
        $nameuser = Auth::user()->name;
    @endphp
    <div class="container-fluid">
        <form id="formulario" method="post">
          {{ csrf_field() }}
            <div class="row">
                <div class="card card-warning col-md-12 col-xs-12">
                    <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <label class="card-title col-md-6 col-xs-6 ">{{ __('Datos Empleado') }}</label>
                                <div class="col-md-6 col-xs-6" style="text-align: right;">
                                   <button class="btn btn-success"  type="button" onclick="reload()"><i class="far fa-file"></i></button>
                                </div>
                            </div>
                    </div>
                    <div class="card-body">
                    <div class="col-md-12 col-xs-6">
                            <label>Datos</label>
                    </div>
                    <div class="col-md-12 col-xs-6" >
                            <div class="form-row">
                                <div class="form-group col-6 col-xs-6 col-md-6">
                                        <label class="form-control-label" for="codigo">{{ __('Código de Pedido:') }}</label>
                                        <input type="text" class="form-control" name="codigo_pedido" id="codigo_pedido" value="{{$numero}}" readonly>
                                </div>
                                <div class="form-group col-6 col-xs-6 col-md-6">
                                        <label class="form-control-label" for="codigo">{{ __('Fecha de Pedido:') }}</label>
                                        <input type="date" class="form-control" name="fecha" id="fecha" value="{{date('Y-m-d')}}" >
                                </div>
                                <div class="form-group col-6 col-xs-6 co-xl-12 col-md-6">
                                        <label class="form-control-label" for="codigo">{{ __('Maestro :') }}</label>
                                        <select class="form-control select2" name="id_cliente" id="id_cliente">
                                            <option value="">Seleccione...</option>
                                            @foreach($empleados as $value)
                                                <option value="{{$value->ci}}">{{$value->nombre}}</option>
                                            @endforeach
                                        </select>
                                </div>
                                <div class="form-group col-6 col-xs-6 col-md-6">
                                        <label class="form-control-label" for="codigo">{{ __('Registrado por:') }}</label>
                                        <input class="form-control" type="text" name="registrado" id="registrado" name="registrado" value="{{$nameuser}}" readonly>
                                </div>
                            </div>
                    </div>
                    </div>

                </div>
                <div class="card col-md-12 col-xs-12" style="left: 3px;">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <label class="col-12 col-xs-6">Formulario de entrega Insumos</label>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Escanear Código de Barras</label>
                                <input type="hidden" name="contador" id="contador" value="0">
                                <input type="text" class="form-control producto" name="codigoEscaneado" id="codigoEscaneado" autocomplete="off" onchange="buscarArticulo();">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Nombre Producto :</label>
                                <input type="text" class="form-control producto" name="nombreProdu" id="nombreProdu" autocomplete="off" onchange="buscarNombre();">
                            </div>
                        </div>

                        <div class="table table-responsive">
                            <table class="table table-striped" id="tablaAgregarArticulos">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Stock Máximo</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
						        <tbody>

						        </tbody>
					        </table>
                        </div>
                        <div class="col-md-12 align-items-center" style="text-align: center">
                            <button type="button" onclick="guardar()" class="btn btn-primary"><li class="far fa-fw fa-save"></li></button>
                        </div>
                    </div>
                </div>
            </div>

        </form>


    </div>
    <script type="text/javascript">

        $(document).ready(function(){

            generar_codigo();
            $('.select2').select2({
                tags: false
             });
        });
        function generar_codigo(){

        }
        function valida_codigo() {
            var suma = 0;
            var contador = parseInt($('#contador').val());
            var final_codigo = $('#codigoEscaneado').val();
            for (i = 0; i <= contador; i++) {
                codigo = ($('#codProdu' + i).val());
                if (codigo == final_codigo) {
                    return true;
                }

            }
            return false;

        }
        function valida_codigo2() {
            var suma = 0;
            var contador = parseInt($('#contador').val());
            var final_codigo = $('#nombreProdu').val();
            for (i = 0; i <= contador; i++) {
                codigo = ($('#nombreD' + i).val());
                if (codigo == final_codigo) {
                    return true;
                }

            }
            return false;

        }
        function buscarArticulo(){
            var form = $('#codigoEscaneado').val();
            var validacion= valida_codigo();
            if(validacion){
                Swal.fire('Error','Error el articulo ya se encuentra incluido','error');
            }else{
                $.ajax({
                url: "{{route('producto.buscar_codigo')}}",
                type:'GET',
                data: {'codigoEscaneado':form},
                dataType: 'json',
                success: function(data) {
                    if (data.length === 0) {
                        Swal.fire('No Encontrado');
                        $('#codigoEscaneado').val('');
                        $('#codigoEscaneado').focus();
                    } else{
                        Swal.fire('Correcto','Artículo encontrado','success');
                        agregarArticulo(data);

                    }
                },
                error: function(data) {
                    Swal.fire('Se ha producido un error al intentar buscar el Artículo.');
                }
            });
            }
            
        }
        function buscarNombre(){
            var form = $('#nombreProdu').val();
            var validacion= valida_codigo2();
            if(validacion){
                Swal.fire('Error!','El artículo ya se encuentra incluido','error');
            }else{
                $.ajax({
                url: "{{route('producto.buscar_nombre')}}",
                type:'GET',
                data: {'codigoEscaneado':form},
                dataType: 'json',
                success: function(data) {
                    if (data.length === 0) {
                        Swal.fire('No Encontrado');
                        $('#nombreProdu').val('');
                        $('#nombreProdu').focus();
                    } else{
                        Swal.fire('Correcto','Artículo encontrado','success');
                        agregarArticulo(data);

                    }
                },
                error: function(data) {
                    Swal.fire('Error!','Se ha producido un error al intentar buscar el Artículo.','error');
                }
            });
            }
            
        }


        function agregarArticulo(articulo){
            var contador= parseInt($('#contador').val());
            var validacion= valida_codigo2();
            var validacion2= valida_codigo();
            if (validacion && validacion2) { // si ya esta agregado advierto
                Swal.fire('Error!','El artículo ya se encuentra incluido','error');
            } else { // si es nuevo agrego

                var tr = '';
                var btnEliminar = '<button type="button" class="btn btn-xs btn-danger" onclick="$(this).parent().parent().remove();"><i class="far fa-fw fa-trash-alt"></i></button>';
                var inputId = '<input type="hidden" name="codProdu'+contador+'" id="codProdu'+contador+'" value="' + articulo.codigo + '" />';
                var nombres= '<input type="hidden" name="nombreD'+contador+'" id="nombreD'+contador+'" value="' + articulo.nombre + '" />';
                var inputCantidad = '<input type="hidden" name="detCantidadModal[' + articulo.codigo + ']" value="' + articulo.cantidad + '" />';
                var cantidadI= '<input class="form-control" type="text" id="cantidad_max'+contador+'" value="' + articulo.cantidad + '" readonly />';
                var limted= '<input class="form-control" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" name="cantidad'+contador+'" id="cantidad'+contador+'" onchange="validar_cantidad('+contador+')"   this.value=0" type = "text"/>'
                tr += '<tr>';
                    tr += '<td>' + articulo.nombre + '</td>';
                    tr += '<td>' + limted + '</td>';
                    tr += '<td>' + cantidadI + '</td>';
                    tr += '<td>' + btnEliminar + inputId + inputCantidad +nombres+ '</td>';
                tr += '</tr>';
                contador+=1;
                $('#contador').val(contador);
                $('#tablaAgregarArticulos tbody').append(tr);
            }

            $('#codigoEscaneado').val('');
            $('#nombreProdu').val('');
            $('#codigoEscaneado').focus();
        }
        function validar_cantidad(id){
            if(id!='' || id!=null){
                var cantidad= parseInt($('#cantidad_max'+id).val());
                var cantidad_f= parseInt($('#cantidad'+id).val());

                if(!isNaN(cantidad)){
                    if(cantidad_f>cantidad){
                        $('#cantidad'+id).val('');
                        Swal.fire('Error','Error no puedes usar más del stock del producto','error');
                    }

                }else{
                    console.log("Error cantidad");
                }
            }else{
                console.log("Error");
            }
        }
        function guardar(){
            var formulario = document.forms["formulario"];
            var contador= formulario.contador.value;
            var id_cliente= formulario.id_cliente.value;
            var fecha= formulario.fecha.value;
            var msj = "";
            if(contador==0){
                 msj+="Por favor, Llene la tabla de productos <br/>";
            }
            if(id_cliente==""){
                 msj+="Por favor, Llene el campo empleado <br/>";
            }
            if(fecha==""){
                 msj+="Por favor, Llene el campo fecha <br/>";
            }
            if(msj==""){
            //alert("entras");
                    $.ajax({
                            type: 'post',
                            url:"{{route('entrega.store')}}",
                            headers:{'X-CSRF-TOKEN':$('input[name=_token]').val()},
                            datatype: 'json',
                            data: $('#formulario').serialize(),
                            success: function(data){
                                Swal.fire('Correcto','Entrega correcta','success');
                                window.setTimeout(function () {
                                    location.href='{{route('entrega')}}';
                                }, 1000);

                            },
                            error: function(data){
                                console.log(data);
                            }
                    })
            }else{
                Swal.fire({
                  title: "Error!",
                  icon: 'error',
                  type: "error",
                  html: msj
                });
            }
        }
        function reload(){
            location.href="{{route('entrega')}}";
        }

    </script>
@endsection
