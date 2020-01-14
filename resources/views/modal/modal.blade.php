@extends('roles.index')
@section('modal')
<!---->
<!-- Modal -->
<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
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
        <a  href="{{ route('roles.index') }}" class="btn btn-sm btn-secondary">Cancelar</a>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>
      $( document ).ready(function() {
          
        $('#modal1').modal('show');
      });
</script>
@endsection
