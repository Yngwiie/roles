@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Bienvenido!</div>
    
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        
                    @endif
                    <li><strong> Si no tienes un rol asignado haga click en el boton para informar al administrador.</strong></li>
                    <a href="{{route('users.enviarcorreo',auth()->user()->id)}}" 
                                        class="btn btn-secondary btn-sm">Enviar Correo</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
