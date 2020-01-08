@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="width: 75rem; margin-left:-220px;">
                <div class="card-header">
                    <strong >Usuarios</strong>
                    
                    {!! Form::open(['route'=>'users.index','method' =>'GET',
                    'class'=>'form-inline float-right']) !!}
                        {!! Form::text('busqueda',null,['class'=>'form-control form-control mr-3 w-30',
                        'placeholder'=>'Buscar','aria-label'=>'Search'])!!}
                        
                        {{ Form::button('<i class="fas fa-search" aria-hidden="true"></i>', ['type' => 'submit', 
                        'class' => 'btn btn-sm'] )  }}
                    {!!Form::close()!!}
                </div>
                    
                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th widht="10px">ID</th>
                                <th>Nombre</th>
                                <th>Rut</th>
                                <th>Eliminado</th>
                                <th>Estado</th>
                                <th colspan="3">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->rut}}</td>
                                @if (empty($user->deleted_at))
                                    <td>No</td>
                                @else
                                    <td>Si</td>
                                @endif
                                @if (empty($user->email_verified_at))
                                    <td>No verificado</td>
                                @else
                                    <td>Verificado</td>
                                @endif
                                <td width="10px">
                                    @can('users.show')<!-- Si tiene permiso para ver usuario se mostrara el boton-->
                                        <a href="{{route('users.show',$user->id)}}" 
                                        class="btn btn-secondary btn-sm">Ver</a>
                                    @endcan
                                </td>
                                <td width="10px">
                                    @can('users.edit')<!-- Si tiene permiso para editar usuario se mostrara el boton-->
                                        <a href="{{route('users.edit',$user->id)}}" 
                                        class="btn btn-secondary btn-sm">Editar</a>
                                    @endcan
                                </td>
                                
                                <td width="10px">
                                    @can('users.destroy')<!-- Si tiene permiso para eliminar usuario se mostrara el boton-->
                                        {!!Form::open(['route' => ['users.destroy',$user->id],
                                        'method' => 'DELETE' ]) !!}
                                            
                                            <button onclick="return confirm('¿Estas seguro?')" class="btn btn-sm btn-danger">
                                            Eliminar
                                            </button>
                                        {!!Form::close()!!}
                                        
                                    @endcan
                                </td>
                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$users->render()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
