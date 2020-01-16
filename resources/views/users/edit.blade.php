@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card animated fadeIn shadow-lg">
                <div class="card-header"> 
                <a class="btn" onClick="volver()" href="#"><i class="fas fa-arrow-alt-circle-left fa-lg" ></i></a>
                <strong>Usuario</strong>
                </div>
                    
                <div class="card-body">
                    {!! Form::model($user, ['route' => ['users.update',$user->id],
                    'method' => 'PUT']) !!}
                        @include('users.formulario.form')
                    {!!Form::close()!!}
                    
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