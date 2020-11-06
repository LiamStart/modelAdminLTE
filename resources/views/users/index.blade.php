@extends('adminlte::page')
@section('content')
@php
        $rolUsuario = Auth::user()->id_tipo;
@endphp
 <div class="header ">
<div class="container-fluid">
</div>
</div>
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Usuarios</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('user.create')}}" class="btn  btn-sm bg-gradient-primary">Agregar</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <table id="example1" class="table table-bordered table-striped dataTable dtr-inline" role="grid" aria-describedby="example1_info">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Creation Date</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $users)
                                        <tr>
                                            <td>{{$users->id}}</td>
                                            <td>{{$users->name}}</td>
                                            <td>{{$users->email}}</td>
                                            <td>{{$users->created_at}}</td>
                                            <td>@if(isset($users->tipo->nombre)){{$users->tipo->nombre}}@endif</td>
                                            <td>
                                                @if(($users->id_tipo)!=1)
                                                <a class="btn btn-block btn-sm btn-warning" href="{{route('users.edit',['id'=>$users->id])}}"><i class="far fa-fw fa-edit"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
        </div>
    </div>

@endsection
