@extends('adminlte::page')
@section('content')
<!-- Modal -->
 @php
         $nameuser = Auth::user()->name;
    @endphp
<div class="container-fluid ">
    <form id="formulario" method="post">
        {{ csrf_field() }}
        <div class="card">
            <div class="card-header bg-gradient-info">
                   <div class="row align-items-center">
                                 <h3 class="card-title col-md-6 col-xs-6 ">{{ __('Ingreso Insumo') }}</h3>
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
                                <div class="form-group col-6 col-xs-6 col-md-6">
                                        <label class="form-control-label" for="codigo">{{ __('Empleado Externo:') }}</label>
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
                    <input type="hidden" name="contador" id="contador" value="0">
                    <input type="hidden" name="iva_par" id="iva_par" value="{{$iva}}">
                    <div class="col-md-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Código Producto</th>
                                    <th>Nombre Producto</th>
                                    <th>Tipo Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>IVA</th>
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
                    <div class="col-md-12" style="padding-top: 20px">
                            <div class="row">
                               <!-- <div class="col-md-9">
                                   <div class="row">
                                        <div class="col-md-6" style="padding: 5px">
                                            <div class="row">
                                                <label class="col-md-6">Retenciones a la Fuente (Presuntiva)</label>
                                                     <a type="button" href="" style="background-color: #bbb0ad; color: white;" class="btn coloresb" data-toggle="modal" data-target="#modalretenciones">
                                                     <b>&nbsp;&nbsp;</b>AGREGAR
                                                     </a>
                                                <input type="hidden" name="retenciones1" id="retenciones1">
                                            </div>
                                        </div>
                                   </div>

                                </div>-->
                                <div class=" col-md-9">
                                    &nbsp;
                                </div>
                                <div class="col-md-3">
                                    <div class="col-md-12" style="padding: 8px">
                                        <div class="row">
                                            <label class="col-md-6">Subtotal</label>
                                            <input class="col-md-6" type="text" name="subtotal_final" id="subtotal_final" disabled  >
                                            <input type="hidden" name="subtotal_final1" id="subtotal_final1" class="hidden">
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="padding: 5px">
                                        <div class="row">
                                            <label class="col-md-6">Iva</label>
                                            <input class="col-md-6" type="text" name="iva_final" id="iva_final" disabled>
                                            <input type="hidden" name="iva_final1" id="iva_final1" class="hidden">
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="padding: 5px">
                                        <div class="row">
                                            <label class="col-md-6">Total</label>
                                            <input class="col-md-6" type="text" name="total_final" id="total_final" disabled>
                                            <input type="hidden" name="total_final1" id="total_final1" class="hidden">
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="col-md-12 align-items-center" style="text-align: center">
                            <button type="button" onclick="guardar()" class="btn btn-primary"><li class="far fa-fw fa-save"></li></button>
                    </div>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function(){

        $('#formulario').trigger("reset");

    });
    $('.select2').select2({
                tags: false
             });
    function crea_td(contador){

            id= document.getElementById('contador').value;
            var midiv = document.createElement("tr")
            midiv.setAttribute("id","dato"+id);
            midiv.innerHTML = '<td><input class="form-control input-sm" name="codigo'+id+'" class="codigo" id="codigo'+id+'" onchange="cambiar_codigo('+id+')"/></td> <td><input type="hidden" id="visibilidad'+id+'" name="visibilidad'+id+'" value="1"> <input type="hidden" name="extendido'+id+'" id="extendido'+id+'"> <input name="nombre'+id+'" class="nombre form-control input-sm" id="nombre'+id+'" class="form-control input-sm"</td><td><select name="tipo'+id+'" id="tipo'+id+'" class="form-control select2"> @foreach($tipo as $value) <option value="{{$value->id}}">{{$value->nombre}}</option>  @endforeach </select></td><td> <input type="text" class="form-control input-sm" name="cantidad'+id+'" id="cantidad'+id+'" value="0.00" onkeyup="total_calculo('+id+')" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" onchange="validarcantidad(this, '+id+');"> </td> <td><input  type="text" id="precio'+id+'" name="precio'+id+'" value="0.00" onkeyup="total_calculo('+id+');" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" class="form-control input-sm" onchange="validarprecio(this,'+id+');"></td> <td> <input type="checkbox" id="iva'+id+'" name="iva'+id+'" onchange="suma_totales('+id+')" value="1"> </td> <td><button id="eliminar'+id+'" type="button" onclick="javascript:eliminar_registro('+id+')" class="btn btn-danger btn-gray delete btn-xs"> <i class="far fa-fw fa-trash-alt"></i></button></td>';
            document.getElementById('det_recibido').appendChild(midiv);
            id = parseInt(id);
            id = id+1;
            document.getElementById('contador').value = id;
            $('.select2').select2({
                tags: false
             });

    }
    function cambiar_codigo(id){
        $.ajax({
            type: 'get',
            url:"{{route('producto.buscar_codigo')}}",
            datatype: 'json',
            data: {'codigoEscaneado':$("#codigo"+id).val()},
            success: function(data){
                console.log(data);
                if(data!='No hay coincidencias'){
                    Swal.fire('Error!','Existen coincidencias con producto','error');
                    $('#codigo'+id).val('');
                }
            },
            error: function(data){
                console.log(data);
            }
        })
    }
    function validarprecio(elemento, id){

        var cod = $('#codigo'+id).val();
        var nomb = $('#nombre'+id).val()

        if((cod.length == 0)&&(nomb.length == 0)){
            Swal.fire("Error!","Debe ingresar el código, nombre, cantidad del producto","error");
            $('#precio'+id).val("0");
            $('#desc'+id).val("0");
            $('#extendido'+id).val("0");
            return false;
        }

        var prec = elemento.value;
        if (prec.length == 0){

            Swal.fire("¡Error!","Ingrese de nuevo","error");
            $('#precio'+id).val("0");
            total_calculo(id);
            //suma_totales();
            return false;
        }

        var numero = parseInt(elemento.value,10);
        //Validamos que se cumpla el rango
        if(numero<-1 || numero>999999999){
            Swal.fire("Precio no Permitido");
            $('#precio'+id).val("0");
            return false;
        }
        var total= parseFloat(elemento.value);
        $('#precio'+id).val(total.toFixed(2,2));
        return true;
    }
    function validarcantidad(elemento, id){

        var cod = $('#codigo'+id).val();
        var nomb = $('#nombre'+id).val()
        if((cod.length == 0)&&(nomb.length == 0)){
            Swal.fire("Debe ingresar el código","Nombre del producto","error");
            $('#cantidad'+id).val("0");
            $('#desc'+id).val("0");
            $('#extendido'+id).val("0");
            return false;
        }
        var num = elemento.value;
        if (num.length == 0){
            Swal.fire("Cantidad no Permitida","Por favor ingrese de nuevo","error");
            $('#cantidad'+id).val("0");
            suma_totales();
            return false;
        }


        var numero = parseInt(elemento.value,10);
        if(numero<-1 || numero>999999999){
            Swal.fire("Cantidad no Permitida","Por favor ingrese de nuevo","error");
            $('#cantidad'+id).val("0");
            return false;
        }
        var total= parseFloat(elemento.value);
        $('#cantidad'+id).val(total.toFixed(2,2));
        return true;
    }
    function total_calculo(id){
        total = 0;
        descuento_total = 0;
        cantidad = parseInt($("#cantidad"+id).val());
        precio = parseFloat($("#precio"+id).val());
        //alert(descuento);
        total = cantidad * precio;
        //lert(cantidad);
        //alert(descuento_total);
        $('#desc'+id).val(descuento_total.toFixed(2));
        $('#extendido'+id).val(total.toFixed(2));
        $('#extendido1'+id).val(total.toFixed(2));
        suma_totales();
    }

    function suma_totales(){
        contador  =  0;
        iva = 0;
        total = 0;
        sub = 0;
        descu1 = 0;
        total_fin = 0;
        descu = 0;
        cantidad = 0;
        $("#det_recibido tr").each(function(){
        $(this).find('td')[0];
            visibilidad = $(this).find('#visibilidad'+contador).val();
            if(visibilidad == 1){

                cantidad = parseFloat($(this).find('#cantidad'+contador).val());
                valor = parseFloat($(this).find('#precio'+contador).val());
                //alert(valor);
                pre_neto = parseFloat($(this).find('#extendido'+contador).val());
                total = cantidad * valor;
                if($('#iva'+contador).prop('checked') ) {
                    console.log("iva chequeado");
                    var iva_par = $('#iva_par').val();
                    var cod = $('#codigo'+contador).val();
                    var nomb = $('#nombre'+contador).val();
                    if((cod.length == 0)&&(nomb.length == 0)){
                        swal("Error!","Debe ingresar el código, nombre del Producto o Servicio","error");
                        $('#iva'+contador).prop('checked',false);
                    }
                    if(total>0){
                    sub = sub + total;
                    }
                    //iva = sub * 0.12;

                    iva1 = pre_neto * 0.12;
                    iva = iva + iva1;


                }else{
                    if(total>0){
                    sub = sub + total;
                    }
                }


            }
            contador = contador+1;
        });
            var ivaf= parseFloat($("#iva_par").val());
            var dsiva=0;
            if(iva>0){
                dsiva = sub *ivaf;
            }
            console.log("iva es "+iva);
            trans = parseFloat($('#transporte').val());
            total_fin = parseFloat((sub)+iva);
            if(!isNaN(sub)){  $('#subtotal_final').val(sub.toFixed(2));}
            if(!isNaN(iva)){ $('#iva_final').val(iva.toFixed(2));   }
            if(!isNaN(total_fin)){ $('#total_final').val(total_fin.toFixed(2)); }
            $('#subtotal_final1').val(sub.toFixed(2));
            $('#iva_final1').val(dsiva.toFixed(2));
            $('#total_final1').val(total_fin.toFixed(2));
        //alert(total_fin);

    }
    function eliminar_registro(valor)
    {
        var dato1 = "dato"+valor;
        var nombre2 = 'visibilidad'+valor;
        document.getElementById(nombre2).value = 0;
        document.getElementById(dato1).style.display='none';
        suma_totales();
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
                            url:"{{route('producto.ingreso_store')}}",
                            headers:{'X-CSRF-TOKEN':$('input[name=_token]').val()},
                            datatype: 'json',
                            data: $('#formulario').serialize(),
                            success: function(data){
                                Swal.fire('Correcto','Entrega correcta','success');
                                window.setTimeout(function () {
                                    location.href='{{route('producto.ingreso')}}';
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
        location.href="{{route('producto.ingreso')}}";
    }

</script>
@endsection
