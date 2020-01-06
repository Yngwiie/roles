<div class="form-group">
    {{ Form::label('name','Nombre del usuario') }}
    {{ Form::text('name',null,['class'=>'form-control']) }}
</div>

<div class="form-group">
    {{ Form::label('email','Email')}}
    {{ Form::text('email',null,['class' => 'form-control']) }}
</div>

<div class="form-group ">
    <label class="float-left">
    {{ Form::label('password','Antigua Contraseña')}}
    {{ Form::password(null,null,['class' => 'form-control']) }}
    </label>
</div>

<div class="form-group">
    {{ Form::label('password','Nueva Contraseña')}}
    {{ Form::password(null,null,['class' => 'form-control']) }}
</div>

<div>
    {{ Form::submit('Guardar', ['class' =>'btn-sm btn-secondary'])}}
</div>