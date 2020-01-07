@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" >
                <div class="card-header">
                    Roles
                    @can('roles.create')
                    <a href="{{ route('roles.create') }}" 
                    class="btn btn-sm btn-secondary float-right">
                    Crear</a>
                    @endcan
                </div>
                    
                <div class="card-body" >
                    <table class="table table-striped table-hover" >
                        <thead class="thead-dark">
                            <tr>
                                <th widht="10px">ID</th>
                                <th>Nombre Rol</th>
                                <th colspan="3">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                            <tr>
                                <td>{{$role->id}}</td>
                                <td >{{$role->name}}</td>
                                <td width="10px">
                                    @can('roles.show')<!-- Si tiene permiso para ver se mostrara el boton-->
                                        <a href="{{route('roles.show',$role->id)}}" 
                                        class="btn btn-secondary btn-sm">Ver</a>
                                    @endcan
                                </td>
                                <td width="10px">
                                    @can('roles.edit')<!-- Si tiene permiso para editar se mostrara el boton-->
                                        <a href="{{route('roles.edit',$role->id)}}" 
                                        class="btn btn-secondary btn-sm">Editar</a>
                                    @endcan
                                </td>
                                <td width="10px">
                                    @can('roles.destroy')<!-- Si tiene permiso para eliminar se mostrara el boton-->
                                        {!!Form::open(['route' => ['roles.destroy',$role->id],
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
                    {{$roles->render()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
