@extends('adminlte::page')

@section('content')
@php
        $rolUsuario = Auth::user()->id_tipo;
@endphp
<div class="ontainer-fluid">
   <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{$fact_ingreso}}</h3>

                <p>Pagos Pendientes</p>
              </div>
              <div class="icon">
                <i class="icon ion ion-bag"></i>
              </div>
              <a href="{{route('factura_ingreso')}}" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{$producto}}</h3>

                <p>Existencia de Producto</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="{{route('producto')}}" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{$userx}}</h3>

                <p>Usuarios Registrados</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{$factura_v}}</h3>

                <p>Facturas de Ventas</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="{{route('ventas')}}" class="small-box-footer">Ver más<i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
  </div>
    <div class="card">
        <div class="card-header ">
                <h6 class="title d-inline">SECCIÓN CUMPLEAÑOS USUARIOS</h6>
        </div>

        <div class="card-body ">
            <div class="table table-responsive">
            @if(in_array($rolUsuario, array(2)) == false)
                <div class="form-group col-md-12">
                @if(($ch ?? '' == Array()) && ($ca == Array()) && ($pm == Array()))
                    <h2>No hay Cumpleañeros en los proximos Meses</h2>
                @endif
                @if($ch ?? '' != Array())
                    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">

                        <div class="table-responsive col-md-12">
                        <h2>Cumpleañeros del Dia de Hoy</h2>
                        <table id="example2" class="table tablesorter" role="grid" aria-describedby="example2_info">
                            <tbody>
                            @foreach ($ch ?? '' as $value)
                                <tr role="row" class="odd">
                                <td class="sorting_1"> <h3>{{ $value->name}} </h3></td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        </div>

                    </div>
                @endif
                @if($ca != Array())
                    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">

                        <div class="table-responsive col-md-12">
                        <h2>Cumpleañeros de este Mes</h2>
                        <table id="example22" class="table table-striped" role="grid" aria-describedby="example2_info">
                            <thead>
                            <tr role="row">
                                <th width="10%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" >Foto</th>
                                <th width="30%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Name: activate to sort column descending" aria-sort="ascending">Nombre</th>
                                <th width="30%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" >Dia</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($ca as $value)
                                <tr role="row" class="odd">
                                <td>
                                    <img src="{{asset('/img/users/'.$value->url_image)}}"  alt="User Image"  style="width: 30%; margin-left: 15%;" id="fotografia_usuario" >
                                </td>
                                <td class="sorting_1"> <h4>{{ $value->name}} </h4></td>
                                <td class="sorting_1"> <h4>{{ substr($value->fecha_nacimiento, 8)}}</h4></td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        </div>

                    </div>
                @endif
                @if($pm != Array())
                    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">

                        <div class="table-responsive col-md-12">
                        <h2>Cumpleañeros del proximo Mes</h2>
                        <table id="example2" class="table table-striped" role="grid" aria-describedby="example2_info">
                            <thead>
                            <tr role="row">
                                <th width="10%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" >Foto</th>
                                <th width="30%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Name: activate to sort column descending" aria-sort="ascending">Nombre</th>
                                <th width="30%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" >Dia</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($pm as $value)
                                <tr role="row" class="odd">
                                <td><input type="hidden" name="carga" value="@if($value->url_image==' ') {{$value->url_image='avatar.png'}} @endif">
                                    <img src="{{asset('/img/users/'.$value->url_image)}}"  alt="User Image"  style="width: 30%; margin-left: 15%;" id="fotografia_usuario" >
                                </td>
                                <td class="sorting_1"> <h4>{{ $value->name}}</h4></td>
                                <td class="sorting_1"> <h4>{{ substr($value->fecha_nacimiento, 8)}}</h4></td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        </div>

                    </div>
                @endif
                </div>
            @else 
             No hay cumpleañeros en este mes.
            @endif
            </div>
        </div>



    </div>

    @if($rolUsuario==1 || $rolUsuario==2)
    <div class="card">
        <div class="card-header">
            <h4>Últimos Accesos al Sistema</h4>
        </div>
        <div class="card-body">
            <div class="table table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Foto</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Último Accesso</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($useraccess as $value)
                            <tr>
                                <td>{{$value->ci}}</td>
                                <td>
                                    <img src="{{asset('/img/users/'.$value->url_image)}}"  alt="User Image"  style="width:10%; margin-left: 15%;" id="fotografia_usuariso" >
                                </td>
                                <td>{{$value->name}}</td>
                                <td>{{$value->email}}</td>
                                <td>{{$value->last_login}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>

@endsection
