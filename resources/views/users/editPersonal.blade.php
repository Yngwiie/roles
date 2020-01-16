@extends('layouts.app')


@if($user->id==auth()->user()->id)<!-- evito que pueda acceder a la vista de editar datos personales de otra ID -->
    @section('content')
        <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card animated fadeIn ">
                    <div class="card-header shadow-sm"> 
                    <a class="btn" onClick="volver()" href="#"><i class="fas fa-arrow-alt-circle-left fa-lg" ></i></a>
                       <strong>Modificar mis datos</strong>  
                    </div>
                        
                    <div class="card-body shadow-lg">
                        {!! Form::model($user, ['route' => ['users.actualizarDatosPersonales',$user->id],
                        'method' => 'put']) !!}
                            @include('users.formulario.formPersonal')
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
@endif


