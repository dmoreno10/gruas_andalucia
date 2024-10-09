@extends('layouts.app')

@section('content')
   <h1>Listado de usuarios</h1>
   <div class="col-md-12">
    Usuarios registrados
    <hr>
        <div class="row card card-outline ">
            <div class="card-header">
                <div class="card-tools">
                    <a href="{{url('/users/create')}}" class="btn btn-primary">
                        Crear Usuario
                        <i class="fa fa-plus"></i>
                    </a>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-responsive table-bordered table-sm table-hover ">
                    <thead>
                        <tr>
                            <th><center>Nombre</center></th>
                            <th><center>Email</center></th>
                            <th><center>Empresa</center></th>
                            <th><center>Oficina</center></th>
                            <th><center>Horario del grupo</center></th>
                            <th><center>Creado</center></th>
                            <th><center>Acciones</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


