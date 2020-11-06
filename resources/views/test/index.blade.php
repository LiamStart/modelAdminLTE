@extends('adminlte::page')
@section('content')
@php
$nameUser = Auth::user()->name;

$sidebar = $_SERVER["REQUEST_URI"];
@endphp
<style type="text/css">
.pagination {
    list-style: none;
    margin: 0px;
    padding: 0px;
}

.pagination li {
    float;
    left;
    margin: 3px;
}

.pagination li a {
    display: block;
    padding: 3px 5px;
    color: #fff;
    background-color: #44b0dd;
    text-decoration: none;
}

.pagination li a.active {
    border: 1px solid #000;
    color: #000;
    background-color: #fff;
}

.pagination li a.inactive {
    background-color: #eee;
    color: #777;
    border: 1px solid #ccc;
}
</style>
<link rel="stylesheet" href="{{asset('jquery.paginate.css')}}" />
<div class="container-fluid ">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h3 class="mb-4">TEST </h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h3 class="col-md-12">Bienvenido {{$nameUser}}</h3>
                    <form action="{{route('test.store')}}" method="POST">
                    <ul id="example" class="callout callout-success">
                        @csrf
                        @php $cuenta=1; @endphp
                        @foreach($preguntas as $value)
                        <li class="card-header" style="display: list-item; opacity: 1;">   
                            <span style="font-size: 20px; font-weight: bold;"> {{$cuenta}} . {{$value->descripcion}}</span>
                            <input type="hidden" name="cabecera{{$cuenta}}" value="{{$value->id}}">
                            <div class="form-group">

                                @php $detalles=
                                DB::table('preguntas_detalle')->where('estado','1')->where('id_cabecera',$value->id)->get();
                                $cuenta2=1; @endphp
                                @foreach($detalles as $xx)
                                <div class="form-check">
                                    <div class="custom-control custom-checkbox">
                                        <input type="hidden" name="detalle[]" value="{{$xx->id}}">
                                        <input class="custom-control-input" type="checkbox" name="mirespuesta[]"
                                            id="mirespuesta{{$cuenta2}}[{{$cuenta}}]" value="{{$xx->id}}">
                                        <label class="custom-control-label" for="mirespuesta{{$cuenta2}}[{{$cuenta}}]"
                                            style="margin-top: 13px; font-size: 14px;"> &nbsp; &nbsp;
                                            {{$xx->opcion}}</label>
                                    </div>
                                </div>
                                <input type="hidden" name="contadorRespuesta[{{$cuenta2}}]" value="{{$cuenta2}}">
                                @php $cuenta2++; @endphp

                                @endforeach


                            </div>
                        </li>
                        @php $cuenta++; @endphp
                        @endforeach
                    </ul>
                        <input type="hidden" name="contador" id="contador" value="{{$cuenta}}">
                        <div class="col-md-12 align-items-center" style="text-align: center">
                            <button type="submit" class="btn btn-primary">
                                <li class="far fa-fw fa-save"></li>
                            </button>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>
    <script src="{{asset('jquery.paginate.js')}}"></script>
    <script>
     $('#example').paginate();

    function checks(checkboxElem) {
        if (checkboxElem.checked) {
            checkboxElem.value = "1";
        } else {
            checkboxElem.value = "0";
        }

    }
    </script>
    @endsection