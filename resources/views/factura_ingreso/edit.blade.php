<div class="modal-content">
			<div class="modal-header">
            <h4 class="modal-title" id="modalArticulosLabel">Detalle Pago</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

			</div>
			<div class="modal-body">
                <form id="forms" method="post">
                {{ csrf_field() }}
                 <input type="hidden" name="id_factura" id="id_factura" value="{{$factura[0]->factura->id}}">
                </form>
                <div class="col-md-12">
                    <div class="row">
                        <label class="col-md-12" style="text-align:center;">Datos</label>
                        <b class="col-md-6">N° {{$factura[0]->factura->id}}</b>
                        <b class="col-md-6">{{$factura[0]->factura->cliente->nombre}}</b>
                        <b class="col-md-12" style="text-align: center;">Total : {{$factura[0]->factura->total_final}}</b>

                    </div>
                </div>
				<div class="table table-responsive">
					<table class="table table-striped" id="tablaAgregarArticulos">
						<thead>
							<tr>
                                <th>Id</th>
								<th>Codigo</th>
								<th>Nombre</th>
                                <th>Cantidad</th>
                                <th>Total</th>
							</tr>
						</thead>
						<tbody>
                            @foreach($factura as $value)
                                <tr>
                                    <td>{{$value->id}}</td>
                                    <td>{{$value->codigo}}</td>
                                    <td>{{$value->nombre}}</td>
                                    <td>{{$value->cantidad}}</td>
                                    <td>{{$value->total}}</td>
                                </tr>
                            @endforeach
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" id="btnCerrarModal">Cerrar</button>
				<button type="button" class="btn btn-primary" id="btnAgregar" onclick="agregar();">Pagar</button>
			</div>
</div>
<script>
    function agregar(){
            $.ajax({
                    type: 'post',
                    url:"{{route('factura_ingreso.pago')}}",
                    headers:{'X-CSRF-TOKEN':$('input[name=_token]').val()},
                    datatype: 'json',
                    data:{variable:'1', id_factura: $('#id_factura').val()},
                    success: function(data){
                        Swal.fire('Correcto','Pago correcto','success');
                        window.setTimeout(function () {
                            location.href='{{route('factura_ingreso')}}';
                        }, 1000);

                    },
                    error: function(data){
                        console.log(data);
                    }
            })
    }
</script>
