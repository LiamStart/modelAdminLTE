
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
       <th style="text-align:center;"> <b>REPORTE DE CAJA</b> <th>
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
        <th style="border: 1px solid black"> <b>Fecha y Hora</b> </th>
        <th style="border: 1px solid black"> <b>Descripción</b> </th>
        <th style="border: 1px solid black"> <b>Ingreso</b></th>
        <th style="border: 1px solid black"> <b>Egreso</b></th>
    </tr>
    </thead>
    <tbody>
    @foreach($caja as $user)
        <tr>
            <td style="border: 1px solid black"> {{ $user->fecha }}</td>
            <td style="border: 1px solid black">{{ $user->descripcion}}</td>
            <td style="border: 1px solid black">{{ number_format ($user->ingreso,2,',','') }}</td>
            <td style="border: 1px solid black">{{ number_format ($user->egreso,2,',','') }}</td>
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
