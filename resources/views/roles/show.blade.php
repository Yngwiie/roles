@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header">
                <a class="btn" onClick="volver()" href="#"><i class="fas fa-arrow-alt-circle-left fa-lg" ></i></a>
                   <strong>Rol</strong>
                </div>
                    
                <div class="card-body">
                    <p><strong>Nombre:</strong> {{$role->name}}</p>
                    <p><strong>URL amigable:</strong> {{$role->slug}}</p>
                    <p><strong>Descripción: </strong> {{$role->description ?: 'Sin Descripción'}}</p>
                    <p><strong>Cantidad de usuarios con el rol: </strong>{{$cantidad_usuarios ?: '0'}}</p>
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