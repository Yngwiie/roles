@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header ">
                <a class="btn" onClick="volver()" href="#"><i class="fas fa-arrow-alt-circle-left fa-lg" ></i></a>
                    <strong>Usuario</strong>
                    <a href="{{ route('users.usuariopdf',$user -> id)}}" 
                    class="btn btn-sm btn-secondary float-right">
                    <i class="fas fa-file-download"></i> Descargar PDF</a>
                </div>
                    
                <div class="card-body">
                    <p><strong>Nombre:</strong> {{$user->name}}</p>
                    <p><strong>Rut:</strong> {{$user->rut}}</p>
                    <p><strong>Email:</strong> {{$user->email}}</p>
                    <p><strong>Fecha de creación:</strong> {{$user->created_at}}</p>
                    <p><strong>Habilitado: </strong> 
                    @if(empty($user->deleted_at))
                        Si
                    @else
                        No
                    @endif
                    </p>
                    <ul class="list-unstyled">
                    <p><strong>Roles asignados:</strong>
                        @if($roles->count()==0)
                            Ningun rol asignado</p>
                        @else
                            @foreach($roles as $role)
                            <li class="list-group-item list-group-item-secondary">
                                <label>
                                <i class="fas fa-angle-double-right"></i>
                                    {{$role->name}}
                                </label>
                            </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    function volver(){
        history.go(-1);
    }
</script>
@endsection