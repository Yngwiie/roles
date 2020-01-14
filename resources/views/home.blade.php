@extends('layouts.app')

@section('content')
<div class="container" >
    <div class="row justify-content-center">
        <div class="col-md-8">
        @if((auth()->user()->roles->count()==0) && ((auth()->user()->cant_correos)>0))
            <div class="card">
                <div class="card-header">
                    Bienvenido
                </div>

                <div class="card-body" >
                        <li><strong><i>No tiene un rol asignado haga click en el boton para informar al administrador.(solo puede enviar {{auth()->user()->cant_correos}} correos)</i></strong></li>
                        <a href="{{route('users.enviarcorreo',auth()->user()->id)}}" 
                                            class="btn btn-secondary btn-sm">Enviar Correo</a>
                </div>
            </div>
        @elseif((auth()->user()->roles->count()==0) && ((auth()->user()->cant_correos)==0))
                <div class="card">
                    <div class="card-header">
                        
                    </div>

                    <div class="card-body" >
                            <li><strong><i>Ya envio tres correos, espere hasta que el administrador le asigne un rol.</i></strong></li>
                            
                    </div>
                </div>
        @else
            <img class="animated infinite pulse" src="/img/bi2.png" style="position:absolute;
                                                  left: -210px;
                                                  top:  55px;">
        @endif
        </div>
    </div>
</div>
@endsection
