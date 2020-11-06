<table id="example1">
                            <thead class="thead-light">
                            <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th style="text-align:center;"> <b>{{$empresa->nombre}}</b> <th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            </tr>
                            <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th style="text-align:center;"> <b>REPORTE DE CAJA</b> <th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            </tr>
                            <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th> Desde <b> {{$fecha_desde}} </b> -  Hasta <b> {{$fecha_hasta}}</b> <th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            </tr>
                                <tr>
                                    <th scope="col"  style="border: 1px solid black">Id</th>
                                    <th scope="col"  style="border: 1px solid black">Caja</th>
                                    <th scope="col"  style="border: 1px solid black">Usuario</th>
                                    <th scope="col"  style="border: 1px solid black">Ventas</th>
                                    <th scope="col"  style="border: 1px solid black">Fecha Inicio</th>
                                    <th scope="col"  style="border: 1px solid black">Fecha Cierre</th>
                                    <th scope="col"  style="border: 1px solid black">Monto Inicio</th>
                                    <th scope="col"  style="border: 1px solid black">Monto Fin</th>
                                   
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($caja as $value)
                                    
                                        <tr>
                                            <td  style="border: 1px solid black">{{$value->id}}</td>
                                            <td  style="border: 1px solid black">{{$value->caja->nombre}}</td>
                                            <td  style="border: 1px solid black">{{$value->usuario->name}}</td>
                                            <td  style="border: 1px solid black">@if(($value->ventas)!=null) {{$value->ventas}} @else 0 @endif</td>
                                            <td  style="border: 1px solid black">@if(($value->fechaini)!=null){{$value->fechaini}} @endif</td>
                                            <td  style="border: 1px solid black">@if(($value->fechafin)!=null){{$value->fechafin}} @else La caja aún no está cerrada @endif</td>
                                            <td  style="border: 1px solid black">{{number_format($value->montoini,2,',','')}}</td>
                                            <td  style="border: 1px solid black">@if(($value->montofin)!=null) {{number_format($value->montofin,2,',','')}} @else 0,00 @endif</td>                                            
                                        </tr>
                                @endforeach
                            </tbody>
</table>