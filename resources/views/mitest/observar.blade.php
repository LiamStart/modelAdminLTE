@extends('adminlte::page')
@section('content')
@php
        $nameUser = Auth::user()->name;
    
        $sidebar = $_SERVER["REQUEST_URI"];
    @endphp

<div class="container-fluid ">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h3 class="mb-4">MI TEST </h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                  
                   
                        @csrf
                        @php $cuenta=1; @endphp
                        @foreach($preguntas as $value)
                        <span style="font-size: 20px; font-weight: bold;"> {{$cuenta}} .  {{$value->descripcion}}</span>
                        <input type="hidden" name="cabecera{{$cuenta}}" value="{{$value->id}}">
                        <div class="form-group">
                          
                            @php $detalles= DB::table('preguntas_detalle')->where('estado','1')->where('id_cabecera',$value->id)->get(); $cuenta2=1; @endphp
                                 @foreach($detalles as $xx)
                                 <div class="form-check">
                                    
                                        <input type="hidden" name="detalle[]" value="{{$xx->id}}">
                                        @foreach($verificar as $z)
                                        @if($z->id_detalle==$xx->id)
                                      
                                        <label for="mirespuesta{{$cuenta2}}[{{$cuenta}}]" style="margin-top: 13px; font-size: 14px;"> &nbsp; &nbsp; R// {{$xx->opcion}}</label>
                                        @else 
                                        
                                        @endif
                                        
                                        @endforeach
                                   
                                 </div>
                                 <input type="hidden" name="contadorRespuesta[{{$cuenta2}}]" value="{{$cuenta2}}">
                                 @php $cuenta2++; @endphp
                                 
                                 @endforeach
                                
                                
                        </div>
                        @php $cuenta++; @endphp
                        @endforeach
                        <input type="hidden" name="contador" id="contador" value="{{$cuenta}}">
                        <div class="col-md-12 align-items-center" style="text-align: center">
                        </div>
                    
                </div>


            </div>
        </div>
    </div>
    <script>
            function checks(checkboxElem){
                if (checkboxElem.checked) {
                    checkboxElem.value="1";
                } else {
                    checkboxElem.value="0";
                }

           }
    </script>
@endsection
