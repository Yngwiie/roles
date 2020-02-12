@extends('layouts.app')
@section('content')
<div class="container-fluid" >

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card animated fadeIn"  >
                <div class="card-header shadow-lg">
                    <strong><i class="fas fa-file-medical-alt fa-2x"></i> Auditoria</strong>                    
                    {!! Form::open(['route'=>'users.log','method' =>'GET',
                    'class'=>'form-inline float-right']) !!}
                        <label for="name" class="col-form-label" style="padding-right: 5px;" >Búsqueda por fechas</label>
                        <input autocomplete="off" name="chec" style="margin-right: 5px;" type="checkbox" id="chec" onChange="comprobar(this);" />
                        {!! Form::text('busqueda',null,['class'=>'form-control form-control mr-3 w-26',
                        'placeholder'=>'nombre o rut','aria-label'=>'Search'])!!}
        
                          
                        <strong><label id="linicial" for="recipient-name" class="col-form-label"style="padding-right: 5px;display:none;">Desde:</label></strong>
                        <input id ="fechai"type="date" class="form-control" name="fechainicio" style="display:none" >
                        <strong><label id="lfinal" for="recipient-name" class="col-form-label"style="padding-right: 5px;display:none;" >Hasta:</label></strong>
                        <input id="fechaf" type="date" class="form-control"  name="fechafinal" style="display:none">
                        {{ Form::button('<i class="fas fa-search" aria-hidden="true"></i>', ['type' => 'submit', 
                        'class' => 'btn btn-sm'] )  }}
                    {!!Form::close()!!}
                </div>

                <div class="card-body shadow-lg" >
                <button type="button" class="btn btn-danger btn-md" data-toggle="modal" data-target="#modal" ><i class="fas fa-trash-alt"></i> Eliminar Datos</button>
                <a type="button" href="{{route('log.excel')}}"class="btn btn-secondary btn-md" style="color:white"><i class="fas fa-file-download"></i> Descargar Excel</a>
                    <table class="table table-responsive table-striped table-hover shadow p-3 " >
                        <thead class="thead-dark">
                            <tr>
                                <th class="col-xs-9 col-md-3">Fecha</th>
                                <th class="col-xs-9 col-md-10">Nombre</th>
                                <th class="col-xs-9 col-md-7">Rut</th>
                                <th class="col-xs-9 col-md-10">Navegador</th>
                                <th width="10px">ip</th>
                                <th class="col-xs-9 col-md-10">Acción</th>
                                <th class="col-xs-9 col-md-10">Valores antiguos</th>
                                <th class="col-xs-9 col-md-10">Valores nuevos</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Si esta vacío  -->
                            @if($logs->count()==0)
                              <tr>
                                  <td><H5>Sin Datos</H5></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                              </tr>
                            @endif

                            @foreach($logs as $log)
                            <tr>
                                <td >{{$log->created_at}}</td>
                                <td >{{$log->name_user}}</td>
                                <td >{{$log->rut}}</td>
                                <td >{{$log->navegador}}</td>
                                <td >{{$log->ip}}</td>
                                <td >{{$log->accion}}</td>
                                <td >{{$log->valores_antiguos}}</td>
                                <td >{{$log->valores_nuevos}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$logs->appends(Request::only(['busqueda','fechainicio','fechafinal']))->render()}}
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
          <button style="color:white" type="submit" class="btn btn-info">Confirmar</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
<script>
         function comprobar(obj)
          {   
              if (obj.checked){
                
                  document.getElementById('fechai').style.display = "";
                  

                  $("#fechai").attr("required", true);
                  
                  document.getElementById('linicial').style.display = "";
                  document.getElementById('lfinal').style.display = "";
                  $("#fechaf").attr("required", true);
                  document.getElementById('fechaf').style.display = "";
              } 
              else{
                    
                  document.getElementById('fechai').style.display = "none";
                  $("#fechai").attr("required", false);
                  document.getElementById('linicial').style.display = "none";
                  document.getElementById('lfinal').style.display = "none";
                  $("#fechaf").attr("required", false);
                  document.getElementById('fechaf').style.display = "none";
              }     
          }

</script>
@endsection