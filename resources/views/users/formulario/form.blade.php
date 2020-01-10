<div class="form-group">
    {{ Form::label('name','Nombre del usuario') }}
    {{ Form::text('name',null,['class'=>'form-control','required']) }}
</div>

<div class="form-group">
    {{ Form::label('email','Email')}}
    {{ Form::text('email',null,['class' => 'form-control','required']) }}
</div>
<hr>
<h3>Lista de roles</h3>
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