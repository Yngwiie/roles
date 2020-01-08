@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Bienvenido!!
                </div>

                <div class="card-body"  >
                    
                    @if(auth()->user()->roles->count()==0)
                        <li><strong><i>No tiene un rol asignado haga click en el boton para informar al administrador.</i></strong></li>
                        <a href="{{route('users.enviarcorreo',auth()->user()->id)}}" 
                                            class="btn btn-secondary btn-sm">Enviar Correo</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
