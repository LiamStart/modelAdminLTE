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
                        <label class="col-6 mb-0 card-title">{{ __('Factura de Venta') }}</label>
                        <div class="col-md-6 col-xs-6" style="text-align: right;">
                            <button class="btn btn-sucess" type="button" onclick="reload()"><i class="far fa-file"></i></button>
                        </div>
                    </div>


                </div>
                <div class="card-body">

                    <input type="hidden" name="contador" id="contador" value="0">
                    <input type="hidden" name="iva_par" id="iva_par" value="{{$iva}}">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label class="form-control-label"> Cantidad :</label>
                                <input class="form-control" type="text" name="cantidad" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" id="cantidad">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-control-label"> Código: </label>
                                <input class="form-control" type="text" name="codigoEscaneado" id="codigoEscaneado" onchange="buscarArticulo()">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-control-label"> Nombre Producto: </label>
                                <input class="form-control" type="text" name="nombreProdu" id="nombreProdu" onchange="buscarNombre()">
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-12 table-responsive">
                        <table class="table table-striped" id="agregaTable">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Descripción</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>IVA</th>
                                    <th>
                                        Acción
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="det_recibido">
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12" style="padding-top: 20px">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="col-md-12" style="padding: 8px">
                                    <div class="row">
                                        <label class="col-md-6">Subtotal</label>
                                        <input class="col-md-6" type="text" name="subtotal_final" id="subtotal_final" readonly>
                                        <input type="hidden" name="subtotal_final1" id="subtotal_final1" class="hidden">
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 5px">
                                    <div class="row">
                                        <label class="col-md-6">Iva</label>
                                        <input class="col-md-6" type="text" name="iva_final" id="iva_final" readonly>
                                        <input type="hidden" name="iva_final1" id="iva_final1" class="hidden">
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding: 5px">
                                    <div class="row">
                                        <label class="col-md-6">Total</label>
                                        <input class="col-md-6" type="text" name="total_final" id="total_final" readonly>
                                        <input type="hidden" name="total_final1" id="total_final1" class="hidden">
                                    </div>
                                </div>
                            </div>
                            <div class=" col-md-9">
                                &nbsp;
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 align-items-center" style="text-align: center">
                        <button type="button" onclick="guardar()" class="btn btn-primary">
                            <li class="far fa-fw fa-save"></li>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card col-lg-3">
                <div class="card-header bg-gradient-lightblue">
                    <div class="row align-items-center">
                        <label class="col-6 card-title">{{ __('Datos de la Factura') }}</label>
                        <a href="{{route('cliente.create')}}" class="btn btn-warning">Agregar Cliente</a>
                    </div>
                </div>
                <div class=" card-body">
                    <div class="form-row">
                        <div class="form-group col-12 col-xs-12 col-md-12">
                            <label class="form-control-label" for="codigo">{{ __('Código de Venta:') }}</label>
                            <input type="text" class="form-control" name="codigo_pedido" id="codigo_pedido" value="{{$numero}}" readonly>
                        </div>
                        <div class="form-group col-12 col-xs-12 col-md-12">
                            <label class="form-control-label" for="codigo">{{ __('N°:') }}</label>
                            <input type="text" class="form-control" name="codigo_pedido" id="codigo_pedido" value="001-@if(!is_null($caja)){{$caja->caja->nro_caja}}-@endif {{$numero}}" readonly>
                        </div>
                        <div class="form-group col-12 col-xs-12 col-md-12">
                            <label class="form-control-label" for="codigo">{{ __('Fecha de Pedido:') }}</label>
                            <input type="date" class="form-control" name="fecha" id="fecha" value="{{date('Y-m-d')}}">
                        </div>
                        <div class="form-group col-12 col-xs-12 col-md-12">
                            <label class="form-control-label" for="codigo">{{ __('Cliente:') }}</label>
                            <select class="form-control select2" name="id_cliente" id="id_cliente">
                                <option value="">Seleccione...</option>
                                @foreach($empleados as $value)
                                <option value="{{$value->ci}}">{{$value->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-12 col-xs-12 col-md-12">
                            <label class="form-control-label" for="formas_pago">{{ __('Formas de Pago :') }}</label>
                            <select class="form-control select2" name="formas_pago" id="formas_pago">
                                <option value="">Seleccione...</option>
                                @foreach($formas_pago as $value)
                                <option value="{{$value->id}}">{{$value->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-12 col-xs-12 col-md-12">
                            <label class="form-control-label" for="codigo">{{ __('Registrado por:') }}</label>
                            <input class="form-control" type="text" name="registrado" id="registrado" name="registrado" value="{{$nameuser}}" readonly>
                        </div>
                        <div class="form-group col-12 col-xs-12 col-md-12" id="addFormap">
                            <label for="Venta">Concepto:</label>
                            <input class="form-control" type="text" name="concepto" id="concepto">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>
<script type="text/javascript">
    $(document).ready(function() {

        $('#formulario').trigger("reset");

    });
    $('.select2').select2({
        tags: false
    });

    function crea_td(contador) {

        id = document.getElementById('contador').value;
        var midiv = document.createElement("tr")
        midiv.setAttribute("id", "dato" + id);
        midiv.innerHTML = '<td><input class="form-control input-sm" name="codigo' + id + '" class="codigo" id="codigo' + id + '" onchange="cambiar_codigo(' + id + ')"/></td> <td><input type="hidden" id="visibilidad' + id + '" name="visibilidad' + id + '" value="1"> <input type="hidden" name="extendido' + id + '" id="extendido' + id + '"> <input name="nombre' + id + '" class="nombre form-control input-sm" id="nombre' + id + '" class="form-control input-sm"</td><td> <input type="text" class="form-control input-sm" name="cantidad' + id + '" id="cantidad' + id + '" value="0.00" onkeyup="total_calculo(' + id + ')" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" onchange="validarcantidad(this, ' + id + ');"> </td> <td><input  type="text" id="precio' + id + '" name="precio' + id + '" value="0.00" onkeyup="total_calculo(' + id + ');" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" class="form-control input-sm" onchange="validarprecio(this,' + id + ');"></td> <td> <input type="checkbox" id="iva' + id + '" name="iva' + id + '" onchange="suma_totales(' + id + ')" value="1"> </td> <td><button id="eliminar' + id + '" type="button" onclick="javascript:eliminar_registro(' + id + ')" class="btn btn-danger btn-gray delete btn-xs"> <i class="far fa-fw fa-trash-alt"></i></button></td>';
        document.getElementById('det_recibido').appendChild(midiv);
        id = parseInt(id);
        id = id + 1;
        document.getElementById('contador').value = id;
        $('.select2').select2({
            tags: false
        });

    }

    function cambiar_codigo(id) {
        $.ajax({
            type: 'get',
            url: "{{route('producto.buscar_codigo')}}",
            datatype: 'json',
            data: {
                'codigoEscaneado': $("#codigo" + id).val()
            },
            success: function(data) {
                console.log(data);
                if (data != 'No hay coincidencias') {
                    Swal.fire('Error!', 'Existen coincidencias con producto', 'error');
                    $('#codigo' + id).val('');
                }
            },
            error: function(data) {
                console.log(data);
            }
        })
    }

    function validarprecio(elemento, id) {

        var cod = $('#codigo' + id).val();
        var nomb = $('#nombre' + id).val()

        if ((cod.length == 0) && (nomb.length == 0)) {
            Swal.fire("Error!", "Debe ingresar el código, nombre, cantidad del producto", "error");
            $('#precio' + id).val("0");
            $('#desc' + id).val("0");
            $('#extendido' + id).val("0");
            return false;
        }

        var prec = elemento.value;
        if (prec.length == 0) {

            Swal.fire("¡Error!", "Ingrese de nuevo", "error");
            $('#precio' + id).val("0");
            total_calculo(id);
            //suma_totales();
            return false;
        }

        var numero = parseInt(elemento.value, 10);
        //Validamos que se cumpla el rango
        if (numero < -1 || numero > 999999999) {
            Swal.fire("Precio no Permitido");
            $('#precio' + id).val("0");
            return false;
        }
        var total = parseFloat(elemento.value);
        $('#precio' + id).val(total.toFixed(2, 2));
        return true;
    }

    function validarcantidad(elemento, id) {

        var cod = $('#codigo' + id).val();
        var nomb = $('#nombre' + id).val()
        if ((cod.length == 0) && (nomb.length == 0)) {
            Swal.fire("Debe ingresar el código", "Nombre del producto", "error");
            $('#cantidad' + id).val("0");
            $('#desc' + id).val("0");
            $('#extendido' + id).val("0");
            return false;
        }
        var num = elemento.value;
        if (num.length == 0) {
            Swal.fire("Cantidad no Permitida", "Por favor ingrese de nuevo", "error");
            $('#cantidad' + id).val("0");
            suma_totales();
            return false;
        }


        var numero = parseInt(elemento.value, 10);
        if (numero < -1 || numero > 999999999) {
            Swal.fire("Cantidad no Permitida", "Por favor ingrese de nuevo", "error");
            $('#cantidad' + id).val("0");
            return false;
        }
        var total = parseFloat(elemento.value);
        $('#cantidad' + id).val(total.toFixed(2, 2));
        return true;
    }

    function total_calculo(id) {
        total = 0;
        descuento_total = 0;
        cantidad = parseInt($("#canti" + id).val());
        precio = parseFloat($("#precio" + id).val());
        //alert(descuento);
        total = cantidad * precio;
        //lert(cantidad);
        //alert(descuento_total)
        $('#extendido' + id).val(total.toFixed(2));
        $('#extendido1' + id).val(total.toFixed(2));
        suma_totales();
    }

    function suma_totales() {
        contador = parseInt($('#contador').val());
        iva = 0;
        total = 0;
        sub = 0;
        descu1 = 0;
        total_fin = 0;
        descu = 0;
        cantidad = 0;
        for (i = 0; i <= contador; i++) {
            cantidad = parseFloat($('#canti' + i).val());
            valor = parseFloat($('#precio' + i).val());
            pre_neto = parseFloat($('#extendido' + i).val());
            total = cantidad * valor;
            if ($('#iva' + i).val() == 1) {
                var iva_par = '{{$iva}}';
                var cod = $('#codigo' + i).val();
                var nomb = $('#nombre' + i).val();
                var extendido = $('#extendido' + i).val();
                if (total > 0) {
                    sub = sub + total;
                }
                //iva = sub * 0.12;

                iva1 = extendido * iva_par;
                iva = iva + iva1;


            } else {
                if (total > 0) {
                    sub = sub + total;
                }
            }
        }
        var ivaf = parseFloat($("#iva_par").val());
        var dsiva = 0;
        if (iva > 0) {
            dsiva = sub * ivaf;
        }
        console.log("iva es " + iva);
        trans = parseFloat($('#transporte').val());
        total_fin = parseFloat((sub) + iva);
        if (!isNaN(sub)) {
            $('#subtotal_final').val(sub.toFixed(2));
        }
        if (!isNaN(iva)) {
            $('#iva_final').val(iva.toFixed(2));
        }
        if (!isNaN(total_fin)) {
            $('#total_final').val(total_fin.toFixed(2));
        }
        $('#subtotal_final1').val(sub.toFixed(2));
        $('#iva_final1').val(dsiva.toFixed(2));
        $('#total_final1').val(total_fin.toFixed(2));
        //alert(total_fin);

    }

    function valida_codigo() {
        var suma = 0;
        var contador = parseInt($('#contador').val());
        var final_codigo = $('#codigoEscaneado').val();
        for (i = 0; i <= contador; i++) {
            codigo = ($('#codigo' + i).val());
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
            codigo = ($('#nombre' + i).val());
            if (codigo == final_codigo) {
                return true;
            }

        }
        return false;

    }

    function eliminar_registro(valor) {
        var dato1 = "dato" + valor;
        var nombre2 = 'visibilidad' + valor;
        document.getElementById(nombre2).value = 0;
        document.getElementById(dato1).style.display = 'none';
        suma_totales();
    }

    function guardar() {
        var formulario = document.forms["formulario"];
        var contador = formulario.contador.value;
        var id_cliente = formulario.id_cliente.value;
        var fecha = formulario.fecha.value;
        var msj = "";
        if (contador == 0) {
            msj += "Por favor, Llene la tabla de productos <br/>";
        }
        if (id_cliente == "") {
            msj += "Por favor, Llene el campo empleado <br/>";
        }
        if (fecha == "") {
            msj += "Por favor, Llene el campo fecha <br/>";
        }
        if (msj == "") {
            //alert("entras");
            $.ajax({
                type: 'post',
                url: "{{route('ventas.store')}}",
                headers: {
                    'X-CSRF-TOKEN': $('input[name=_token]').val()
                },
                datatype: 'json',
                data: $('#formulario').serialize(),
                success: function(data) {
                    if(data!='Primero debes abrir caja antes de guardar una factura de venta.'){
                        Swal.fire('Correcto', 'Se guardó correctamente.', 'success');
                        window.setTimeout(function () {
                                location.href='{{route('ventas.create')}}';
                            }, 1000);
                        
                    }else{
                        Swal.fire('Error',data,'error');
                    }
                   
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

    function reload() {
        location.href = "{{route('ventas.create')}}";
    }

    function buscarArticulo() {
        var form = $('#codigoEscaneado').val();
        var formulario = document.forms["formulario"];
        var cantidad = formulario.cantidad.value;
        if (cantidad != "" || cantidad != null) {
            $.ajax({
                url: "{{route('producto.buscar_codigo')}}",
                type: 'GET',
                data: {
                    'codigoEscaneado': form
                },
                dataType: 'json',
                success: function(data) {
                    if (data.length === 0) {
                        Swal.fire('No Encontrado');
                        $('#codigoEscaneado').val('');
                        $('#codigoEscaneado').focus();
                    } else {
                        Swal.fire('Correcto', 'Artículo encontrado', 'success');
                        if (cantidad > data.cantidad) {
                            Swal.fire('Error', 'La cantidad supera los productos existentes || Disponible: ' + data.cantidad, 'error');
                            $('#cantidad').val('');
                            $('#codigoEscaneado').val('');
                        } else {
                            agregarArticulo(data);
                        }

                    }
                },
                error: function(data) {
                    Swal.fire('Error', 'Se ha producido un error al intentar buscar el Artículo.', 'error');
                }
            });
        } else {
            Swal.fire('Error', 'Ingrese el campo cantidad.', 'error');
        }

    }

    function buscarNombre() {
        var form = $('#nombreProdu').val();
        var formulario = document.forms["formulario"];
        var cantidad = formulario.cantidad.value;
        var validacion = valida_codigo2();
        if (!isNaN(cantidad) || cantidad != "" || cantidad != null) {
            if(validacion){
                Swal.fire('Error!', 'El artículo ya se encuentra incluido', 'error');
            }else{
                $.ajax({
                url: "{{route('producto.buscar_nombre')}}",
                type: 'GET',
                data: {
                    'codigoEscaneado': form
                },
                dataType: 'json',
                success: function(data) {
                    if (data.length === 0) {
                        Swal.fire('No Encontrado');
                        $('#nombreProdu').val('');
                        $('#nombreProdu').focus();
                    } else {
                        Swal.fire('Correcto', 'Artículo encontrado', 'success');
                        if (cantidad > data.cantidad) {
                            Swal.fire('Error', 'La cantidad supera los productos existentes || Disponible: ' + data.cantidad, 'error');
                            $('#cantidad').val('');
                            $('#nombreProdu').val('');
                        } else {
                            agregarArticulo(data);
                        }

                    }
                },
                error: function(data) {
                    Swal.fire('Error!', 'Se ha producido un error al intentar buscar el Artículo.', 'error');
                }
            });
            }
            
        } else {
            Swal.fire('Error', 'Ingrese el campo cantidad.', 'error');
        }

    }

    function agregarArticulo(articulo) {
        var contador = parseInt($('#contador').val());
        var validacion = valida_codigo();
        console.log(validacion);
        var cantidad = parseInt($('#cantidad').val());
        if (validacion) { // si ya esta agregado advierto
            Swal.fire('Error!', 'El artículo ya se encuentra incluido', 'error');
        } else { // si es nuevo agrego

            var tr = '';
            var btnEliminar = '<button type="button" class="btn btn-xs btn-danger" onclick="$(this).parent().parent().remove(); total_calculo();"><i class="far fa-fw fa-trash-alt"></i></button>';
            var codigo = '<input type="hidden" name="codigo' + contador + '" id="codigo' + contador + '" value="' + articulo.codigo + '"> <b>' + articulo.codigo + '</b>';
            var descripcion = '<input type="hidden" name="nombre' + contador + '" id="nombre' + contador + '" value="' + articulo.nombre + '" > <b>' + articulo.nombre + '</b>';
            var cantidades = '<input type="hidden" name="canti' + contador + '" id="canti' + contador + '" value="' + cantidad + '" > <b>' + cantidad + '</b>';
            var total_precio = '<input type="hidden" name="precio' + contador + '" id="precio' + contador + '" value="' + articulo.precio + '"> <b>' + articulo.precio + '</b> ';
            var extendido = '<input type="hidden" name="extendido' + contador + '" id="extendido' + contador + '"> <input type="hidden" name="extendido1' + contador + '" id="extendido1' + contador + '"> '
            var vari = '';
            if (articulo.iva == '1') {
                vari = 'SI';
            } else {
                vari = 'NO';
            }
            var iva = '<input type="hidden" name="iva' + contador + '" id="iva' + contador + '" value="' + articulo.iva + '"> <b>' + vari + '</b> ';
            tr += '<tr>';
            tr += '<td>' + codigo + '</td>';
            tr += '<td>' + descripcion + '</td>';
            tr += '<td>' + cantidades + '</td>';
            tr += '<td>' + total_precio + '</td>';
            tr += '<td>' + iva + extendido + '</td>';
            tr += '<td>' + btnEliminar + '</td>';
            tr += '</tr>';
            $('#cantidad').val('');
            $('#agregaTable tbody').append(tr);
            total_calculo(contador);
            contador += 1;
            $('#contador').val(contador);

        }

        $('#codigoEscaneado').val('');
        $('#nombreProdu').val('');
        $('#cantidad').val('');
        $('#codigoEscaneado').focus();
    }

    function agregarPorformas() {
        var select = $('#formas_pago').val();
        if (select == 2) {

        }
    }
</script>
@endsection
