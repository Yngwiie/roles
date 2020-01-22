@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
        @yield('modal')
            <div class="card animated fadeIn"  >
                <div class="card-header shadow-lg">
                    <strong>Roles</strong>                    
                    {!! Form::open(['route'=>'roles.index','method' =>'GET',
                    'class'=>'form-inline float-right']) !!}
                        {!! Form::text('busqueda',null,['class'=>'form-control form-control mr-3 w-30',
                        'placeholder'=>'Buscar','aria-label'=>'Search'])!!}
                        {{ Form::button('<i class="fas fa-search" aria-hidden="true"></i>', ['type' => 'submit', 
                        'class' => 'btn btn-sm'] )  }}
                    {!!Form::close()!!}
                   
                </div>

                <div class="card-body shadow-lg" >
                    <table class="table table-responsive-sm table-striped table-hover shadow p-3" >
                        <thead class="thead-dark">
                            <tr>
                                <th widht="10px">ID</th>
                                <th>Nombre Rol</th>
                                <th colspan="3">
                                    @can('roles.create')
                                        <a href="{{ route('roles.create') }}" 
                                        class="btn btn-sm btn-secondary float-left">
                                        <i class="fas fa-plus"></i> Crear Rol
                                    @endcan
                                </a>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                            <tr>
                                <td>{{$role->id}}</td>
                                <td >{{$role->name}}</td>
                                <td width="10px">
                                    @can('roles.show')<!-- Si tiene permiso para ver se mostrara el boton-->
                                        <a style="width:54px" href="{{route('roles.show',$role->id)}}" 
                                        class="btn btn-secondary btn-sm"><i class="fas fa-search-plus"></i> Ver</a>
                                    @endcan
                                </td>
                                <td width="10px">
                                    @can('roles.edit')<!-- Si tiene permiso para editar se mostrara el boton-->
                                        <a style="width:68px;"href="{{route('roles.edit',$role->id)}}" 
                                        class="btn btn-secondary btn-sm"><i class="fas fa-pencil-alt"></i> Editar</a>
                                    @endcan
                                </td>
                                <td width="10px">
                                    @can('roles.destroy')<!-- Si tiene permiso para eliminar se mostrara el boton-->
                                        {!!Form::open(['route' => ['roles.cantidadusuariosrol',$role->id],
                                        'method' => 'GET' ]) !!}
                                            
                                            <button style="width:83px" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button>
                                        
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
@yield('modal')


@endsection
