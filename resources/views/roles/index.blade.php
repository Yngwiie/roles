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

                                        @if(DB::table('role_user')->where('role_id',$role->id)->exists())
                                            <button style="width:83px" data-toggle="modal" data-target="#modalrol_con_usuarios" onClick="selRol('{{$role->id}}')"class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button>
                                        @else   
                                            <button style="width:83px" data-toggle="modal" data-target="#modalrol_sin_usuarios" onClick="selRol('{{$role->id}}')"class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Eliminar</button>
                                        @endif
                                        
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
<div class="modal fade" id="modalrol_con_usuarios" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Advertencia</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ¡Hay al menos un usuario con el rol asignado!, 
        ¿Está seguro?
      </div>
      <div class="modal-footer">  
            {!!Form::open(['route' => ['roles.destroy'],
                'method' => 'DELETE' ]) !!}       
                <input type="hidden" id="rol_con_usuario" name="idrol" value="">
                <button class="btn btn-info  btn-sm">Confirmar</button>
                                            
            {!!Form::close()!!}
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalrol_sin_usuarios" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Advertencia</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ¿Está seguro?
      </div>
      <div class="modal-footer">  
            {!!Form::open(['route' => ['roles.destroy'],
                'method' => 'DELETE' ]) !!}       
                <input type="hidden" id="rol_sin_usuario" name="idrol" value="">
                <button class="btn btn-info  btn-sm">Confirmar</button>
                                            
            {!!Form::close()!!}
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>

    selRol = function(idPersona){
        $('#rol_con_usuario').val(idPersona);
        $('#rol_sin_usuario').val(idPersona);
    };

</script>


@endsection
