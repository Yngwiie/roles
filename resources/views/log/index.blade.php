@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card animated fadeIn" style="width: 75rem; margin-left:-220px;" >
                <div class="card-header shadow-lg">
                    <strong>Auditoria Usuarios</strong>                    
                    {!! Form::open(['route'=>'users.log','method' =>'GET',
                    'class'=>'form-inline float-right']) !!}
                        {!! Form::text('busqueda',null,['class'=>'form-control form-control mr-3 w-30 ',
                        'placeholder'=>'Buscar','aria-label'=>'Search'])!!}
                        {{ Form::button('<i class="fas fa-search" aria-hidden="true"></i>', ['type' => 'submit', 
                        'class' => 'btn btn-sm'] )  }}
                    {!!Form::close()!!}
                </div>

                <div class="card-body shadow-lg" >
                    <table class="table table-striped table-hover shadow p-3 " >
                        <thead class="thead-dark">
                            <tr>
                                <th widht="10px">ID</th>
                                <th>Nombre</th>
                                <th>Rut</th>
                                <th>Email</th>
                                <th>Navegador</th>
                                <th>ip</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                            <tr>
                                <td>{{$log->id}}</td>
                                <td >{{$log->name_user}}</td>
                                <td >{{$log->rut}}</td>
                                <td >{{$log->email}}</td>
                                <td >{{$log->navegador}}</td>
                                <td >{{$log->ip}}</td>
                                <td >{{$log->created_at}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$logs->render()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection