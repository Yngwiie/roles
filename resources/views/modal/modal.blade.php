@extends('roles.index')
@section('modal')
<!---->
<div id="mymodal" >
    <div class="modal-dialog  animated slideInDown">
        <div class="modal-content border  shadow p-3 ">
            <div class="modal-header">
            </div>
            <div class="modal-body">
                @if($message=='hay personas con rol')
                <p><strong>¿Estas seguro?</strong></p>
                <p><strong>hay al menos 1 persona con el rol.</strong></p>
                @else
                <p><strong>¿Estas seguro?</strong></p>
                @endif
            </div>
            <div class="modal-footer">

                {!!Form::open(['route' => ['roles.destroy',$role->id],
                    'method' => 'DELETE' ]) !!}
                                            
                    <button class="btn btn-danger btn-sm">Confirmar</button>
                                        
                {!!Form::close()!!}
                <a class="btn btn-secondary btn-sm" href="{{ route('roles.index') }}">Cancelar</a>
            </div>  
        </div>
    </div>
</div>

<script>
      $( document ).ready(function() {
          console.log("hola");
        $('#myModal').modal('show')
      });
</script>
@endsection