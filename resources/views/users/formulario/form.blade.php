<div class="form-group">
    {{ Form::label('name','Nombre del usuario') }}
    {{ Form::text('name',null,['class'=>'form-control','required']) }}
</div>

<div class="form-group">
    {{ Form::label('email','Email')}}
    {{ Form::text('email',null,['class' => 'form-control','required']) }}
</div>
<hr>
<h3 class="d-inline-block">Lista de roles</h3>
<span class="d-inline-block" data-placement="right" tabindex="0" data-toggle="tooltip" title="Solo debe seleccionar un rol.">
        <button class="btn " data-placement="right" style="pointer-events: none;" type="button" disabled><i class="far fa-question-circle fa-lg"></i></button>
</span>

<div class="form-group">
    <ul class="list-unstyled">
        @foreach($roles as $role)
        <li>
            <label>
                {{ Form::checkbox('roles[]',$role->id,null) }}
                {{ $role->name}}
                <em>({{$role -> description ?: 'Sin Descripción'}})</em>
             
            </label>
        </li>
        @endforeach
    </ul>
</div>
<div>
    {{ Form::submit('Guardar', ['class' =>'btn-sm btn-secondary'])}}
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>