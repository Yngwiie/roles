@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header ">
                    Usuario
                    <a href="{{ route('roles.create') }}" 
                    class="btn btn-sm btn-secondary float-right">
                    Descargar PDF</a>
                </div>
                    
                <div class="card-body">
                    <p><strong>Nombre:</strong> {{$user->name}}</p>
                    <p><strong>Rut:</strong> {{$user->rut}}</p>
                    <p><strong>Email:</strong> {{$user->email}}</p>
                    <p><strong>Fecha de creación:</strong> {{$user->created_at}}</p>

                    <ul class="list-unstyled">
                    <p><strong>Roles asignados:</strong>
                        @foreach($roles as $role)
                        <li class="list-group-item list-group-item-secondary">
                            <label>
                            <i class="fas fa-angle-double-right"></i>
                                {{$role->name}}
                            </label>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection