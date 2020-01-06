@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> 
                    Usuario
                </div>
                    
                <div class="card-body">
                    {!! Form::model($user, ['route' => ['users.actualizarDatosPersonales',$user->id],
                    'method' => 'PUT']) !!}
                        @include('users.formulario.formPersonal')
                    {!!Form::close()!!}
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection