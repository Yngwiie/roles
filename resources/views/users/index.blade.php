@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card  animated fadeIn" style="">
                <div class="card-header shadow-sm">
                    
                    <strong><i class="fas fa-user-friends fa-2x"></i> Usuarios</strong>
                    
                    {!! Form::open(['route'=>'users.index','method' =>'GET',
                    'class'=>'form-inline float-right']) !!}
                      <label style="padding-right:7px" for="text">Filtro:</label>
                          <select style="margin-right:10px"class="form-control" name="filtro" id="filtro">
                              @if($filtro=='todos' or $filtro==null)
                                  <option value="todos" selected>Todos</option>
                                  <option value="conrol">Usuarios con rol</option>
                                  <option value="sinrol">Usuarios sin rol</option>
                              @elseif($filtro=='conrol')
                                  <option value="todos" >Todos</option>
                                  <option value="conrol" selected>Usuarios con rol</option>
                                  <option value="sinrol">Usuarios sin rol</option>
                              @elseif($filtro=='sinrol')
                                  <option value="todos" >Todos</option>
                                  <option value="conrol">Usuarios con rol</option>
                                  <option value="sinrol" selected>Usuarios sin rol</option>
                              @endif
                          </select>
                        {!! Form::text('busqueda',null,['class'=>'form-control form-control mr-3 w-30',
                        'placeholder'=>'Buscar','aria-label'=>'Search'])!!}
                        
                        {{ Form::button('<i class="fas fa-search" aria-hidden="true"></i>', ['type' => 'submit', 
                        'class' => 'btn btn-sm'] )  }}
                    {!!Form::close()!!}
                </div>
                    
                <div class="card-body shadow-lg">
                  
                    <a type="button" href="{{route('users.excel')}}"class="btn btn-secondary btn-md" style="color:white"><i class="fas fa-file-download"></i> Descargar Excel</a>

                  
                    <table class="table table-responsive table-striped table-hover shadow p-3">
                        <thead class="thead-dark" style="resize: both;">
                            <tr>
                                <th class="col-xs-9 col-md-3" widht="10px">ID</th>
                                <th class="col-xs-9 col-md-10">Nombre</th>
                                <th class="col-xs-9 col-md-10">Rut</th>
                                <th class="col-xs-9 col-md-9">Habilitado</th>
                                <th class="col-xs-9 col-md-9">Rol asignado</th>
                                <th class="col-xs-9 col-md-7" colspan="9">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($users->count()==0)
                              <tr>
                                  <td><H5>Sin Datos</H5></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                              </tr>
                            @endif
                        
                            @foreach($users as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->rut}}</td>
                                @if (empty($user->deleted_at))
                                    <td>Si</td>
                                @else
                                    <td>No</td>
                                @endif
                                @if($user->roles->count()>0)
                                  <td>Si</td>
                                @else
                                  <td>No</td>
                                @endif
                                <td width="10px">
                                    @can('users.show')<!-- Si tiene permiso para ver usuario se mostrara el boton-->
                                        <a style="width:54px" href="{{route('users.show',$user->id)}}" 
                                        class="btn btn-secondary btn-sm">
                                        <i class="fas fa-search-plus"></i> Ver</a>
                                    @endcan
                                </td>
                                <td width="10px">
                                    @can('users.edit')<!-- Si tiene permiso para editar usuario se mostrara el boton-->
                                        <a style="width:74px" href="{{route('users.edit',$user->id)}}" 
                                        class="btn btn-secondary btn-sm">
                                        <i class="fas fa-user-edit"></i> Editar</a>
                                    @endcan
                                </td>
                                
                                <td width="10px">
                                    @can('users.destroy')<!-- Si tiene permiso para eliminar usuario se mostrara el boton-->
                                        @if(empty($user->deleted_at))
                                                <button style="width:95px" id="inh"data-toggle="modal" onClick="selUsuario('{{$user->id}}')" data-target="#modalDeshabilitar" class="btn btn-sm btn-warning">
                                                <span class="fas fa-user-slash"></span> Inhabilitar
                                                </button>
                                        @else

                                                <button style="width:85px" id="hab" data-toggle="modal" onClick="selUsuario('{{$user->id}}')" data-target="#modalHabilitar" class="btn btn-sm btn-success" >
                                                <span class="fas fa-user-check"></span> Habilitar
                                                </button>
                                        @endif
                                        
                                    @endcan
                                </td>
                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$users->appends(Request::only(['busqueda','filtro']))->render()}}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDeshabilitar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="color:red">Advertencia</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ¿Esta seguro?
      </div> 
      <div class="modal-footer">  
            {!!Form::open(['route' => ['users.destroy'],
                'method' => 'DELETE' ]) !!}       
                <input type="hidden" id="userid_inhabilitar" name="user_id_inhabilitar" value="">
                <button class="btn btn-info  btn-sm">Confirmar</button>
                                            
            {!!Form::close()!!}
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalHabilitar" tabindex="-1"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="color:red">Advertencia</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
        
          ¿Esta seguro?
          {!!Form::open(['route' => ['users.restaurar'],
            'method' => 'get' ]) !!}                             
                <input type="hidden" id="userid" name="user_id" value="">

        </div>
        <div class="modal-footer">                           
              <button style="color:white" type="submit" class="btn btn-info btn-sm">Confirmar</button>
              <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
        </div>
        {!!Form::close()!!}
    </div>
  </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>

    selUsuario = function(idPersona){
        $('#userid').val(idPersona);
        $('#userid_inhabilitar').val(idPersona);
    };

</script>

@endsection
