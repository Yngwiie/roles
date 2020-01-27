@extends('layouts.app')

@section('content')
<div class="container-fluid" >
    <div class="row justify-content-left">
        <div class="col-md-12">
            <div class="card animated fadeIn" style="width:100% ;" >
                <div class="card-header shadow-lg">
                    <strong>Auditoria Total</strong> 
                    {!! Form::open(['route'=>'users.logall','method' =>'GET',
                    'class'=>'form-inline float-right']) !!}
                    <span class="d-inline-block" data-placement="right" tabindex="0" data-toggle="tooltip" title="Puede buscar por Acción, valores antiguos, valores nuevos y fechas.">
                        <button class="btn " data-placement="right" style="pointer-events: none;" type="button" disabled><i class="far fa-question-circle fa-lg"></i></button>
                    </span>
                        {!! Form::text('busqueda',null,['class'=>'form-control form-control mr-3 w-30 ',
                        'placeholder'=>'Buscar','aria-label'=>'Search'])!!}
                        {{ Form::button('<i class="fas fa-search" aria-hidden="true"></i>', ['type' => 'submit', 
                        'class' => 'btn btn-sm'] )  }}
                    {!!Form::close()!!}

                </div>
                <div class="card-body shadow-lg">
                    <table class="table table-responsive table-striped table-hover shadow p-3" >
                        <thead class="thead-dark">
                            <tr>
                            <th scope="col">Modelo/id afectado</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Usuario responsable </th>
                            <th scope="col">Ip Usuario responsable </th>
                            <th scope="col">Acción</th>
                            <th scope="col">Valores antiguos</th>
                            <th scope="col">Valores nuevos</th>
                            </tr>
                        </thead>
                        <tbody id="audits">
                            @foreach($audits as $audit)
                            <?php 
                                $auds = $audit->getMetadata(); 
                               
                                $nombre="";
                                $rut="";
                                
                                if($audit["user_id"]==null){
                                    $nombre="";
                                }else{
                                    $nombre=$auds["user_name"];
                                    $rut=$auds["user_rut"];
                                }

                            ?>

                            <tr>
                            
                                <td>{{ $audit->auditable_type }} (id: {{ $audit->auditable_id }})</td>
                                <td>{{ $audit->created_at }}</td>
                                <td>{{ $nombre." ". $rut}}</td>
                                <td>{{ $audit->ip_address}}</td>
                                <!-- Mostrar acciones en español -->
                                @if($audit->event=="created")
                                    <td>Creación</td>
                                @elseif($audit->event=="updated")
                                    <td>Actualización</td>
                                @elseif($audit->event=="deleted")
                                    <td>Eliminación</td>
                                @elseif($audit->event=="restored")
                                    <td>Restauración</td>
                                @else
                                    <td>{{ $audit->event}}</td>
                                @endif
                                <td>
                                <table class="table">
                                    @if($audit->old_values!=null)
                                        @foreach($audit->old_values as $attribute => $value)
                                        <tr>
                                            @if($value!=null)
                                                <td><b>{{ $attribute }}:</b> {{ $value }}</td>
                                            @else
                                                <td><b>{{ $attribute }}:</b> Sin datos</td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    @else
                                        Sin datos
                                    @endif
                                </table>
                                </td>
                                <td>
                                <table class="table">
                                    @foreach($audit->new_values as $attribute => $value)
                                    <tr>
                                        <td><b>{{ $attribute }}</b></td>
                                        <td>{{ $value }}</td>
                                    </tr>
                                    @endforeach
                                </table>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$audits->render()}}
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
@endsection