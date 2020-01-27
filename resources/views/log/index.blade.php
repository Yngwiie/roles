@extends('layouts.app')
@section('content')
<div class="container-fluid" >

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card animated fadeIn"  >
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
                <button type="button" class="btn btn-danger btn-md" data-toggle="modal" data-target="#modal" ><i class="fas fa-trash-alt"></i> Eliminar Datos</button>
                    <table class="table table-responsive table-striped table-hover shadow p-3 " >
                        <thead class="thead-dark">
                            <tr>
                                <th class="col-xs-9 col-md-10">Nombre</th>
                                <th class="col-xs-9 col-md-7">Rut</th>
                                <th class="col-xs-9 col-md-7">Email</th>
                                <th class="col-xs-9 col-md-10">Navegador</th>
                                <th width="10px">ip</th>
                                <th class="col-xs-9 col-md-1">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                            <tr>
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

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Eliminar Datos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{route('log.eliminar')}}" method="get">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Fecha inicial</label>
            <input type="date" class="form-control" id="fechainicio" name="fechainicio" required>
          </div>
          <div class="form-group">
          <label for="recipient-name" class="col-form-label">Fecha final</label>
            <input type="date" class="form-control" id="fechafinal" name="fechafinal" required>
          </div>
          <button type="submit" class="btn btn-info">Confirmar</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
@endsection