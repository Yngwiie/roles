@extends('layouts.fondohome')

@section('content')
<div class="container"  >
    <div class="row justify-content-center">
        <div class="col-md-8">
        @if((auth()->user()->roles->count()==0) && ((auth()->user()->cant_correos)>0))
            <div class="card">

                <div class="card-body" >
                        <li><h5>No tiene un rol asignado, haga click en el boton para informar a los administradores.(solo puede enviar {{auth()->user()->cant_correos}} correos)</h5 ></li>
                        <a href="{{route('users.enviarcorreo',auth()->user()->id)}}" 
                                            class="btn btn-secondary btn-md">Enviar Correo</a>
                </div>
            </div>
        @elseif((auth()->user()->roles->count()==0) && ((auth()->user()->cant_correos)==0))
                <div class="card">
                    
                    <div class="card-body" >
                            <li><h5>Ya envió tres correos, espere hasta que los administradores le asigne un rol.</h5></li>
                    </div>
                </div>
        @else
            <img class="img-conf animated infinite pulse" src="/img/bienvenido4.png" ;>
        @endif
        </div>
    </div>
</div>
@endsection
