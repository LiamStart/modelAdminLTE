
<table>
    <thead>
    <tr>
       <th></th>
       <th style="text-align:center;"> <b>{{$empresa->nombre}}</b> <th>
       <th></th>
       <th></th>
    </tr>
    <tr>
       <th></th>
       <th style="text-align:center;"> <b>REPORTE DE NOMINA</b> <th>
       <th></th>
       <th></th>
    </tr>
    <tr>
       <th></th>
       <th> Desde <b> {{$fecha_desde}} </b> -  Hasta <b> {{$fecha_hasta}}</b> <th>
       <th></th>
       <th></th>
    </tr>
    <tr>
        <th style="border: 1px solid black"  scope="col">Id</th>
        <th style="border: 1px solid black" scope="col">Observaciones</th>
        <th style="border: 1px solid black" scope="col">Cliente</th>
        <th style="border: 1px solid black" scope="col">Subtotal</th>
        <th style="border: 1px solid black" scope="col">Iva</th>
        <th style="border: 1px solid black" scope="col">Total</th>
        <th style="border: 1px solid black" scope="col">Estado</th>
       
    </tr>
    </thead>
    <tbody>
    @foreach($factura_ingreso as $value)
    <tr>

            <td  style="border: 1px solid black">{{$value->id}}</td>
            <td style="border: 1px solid black">{{$value->observaciones}}</td>
            <td style="border: 1px solid black">{{$value->cliente->nombre}}</td>
            <td style="border: 1px solid black">{{$value->subtotal}}</td>
            <td style="border: 1px solid black">{{$value->iva_total}}</td>
            <td style="border: 1px solid black">{{$value->total_final}}</td>
            <td>@if(($value->estado==1)) PENDIENTE PAGO @elseif($value->estado==2) PAGADO @endif</td>
           
    </tr>
    @endforeach
    </tbody>
    <tfoot>
        <tr>
        </tr>
        <tr>
        </tr>
        <tr>
            <td>Firma Responsable</td>
        </tr>
        <tr>
            <td>_____________</td>
        </tr>

    </tfoot>
</table>
