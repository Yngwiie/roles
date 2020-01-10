<div class="form-group">
    {{ Form::label('name','Nombre') }}
    {{ Form::text('name',null,['class'=>'form-control','required']) }}
</div>

<div class="form-group">
    {{ Form::label('slug','URL amigable')}}
    {{ Form::text('slug',null,['class' => 'form-control','required']) }}
</div>

<div class="form-group">
    {{ Form::label('description','Descripción') }}
    {{ Form::textarea('description',null,['class'=>'form-control','required']) }}
</div>
<hr>
<h3>Permiso especial</h3>
<div class="form-group">
    <label >{{ Form::radio('special','all-access') }}Acceso Total</label>
    <label >{{ Form::radio('special','no-access') }}Ningun Acceso </label>
    <input class="btn btn-secondary btn-sm" type="button" name="res" value="Deseleccionar" onclick="unselect()"> 
</div>
<h3>Lista de permisos</h3>
<div class="form-group">
    <ul class="list-unstyled">
        @foreach($permissions as $permission)
        <li>
            <label>
                {{ Form::checkbox('permissions[]',$permission->id,null) }}
                {{ $permission->name}}
                <em>({{$permission -> description ?: 'Sin Descripción'}})</em>
             
            </label>
        </li>
        @endforeach
    </ul>
</div>
<div>
    {{ Form::submit('Guardar', ['class' =>'btn-sm btn-secondary'])}}
</div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script >

    function unselect(){
        var aItems = document.getElementsByName("special");
        for (var i = 0; i < aItems.length; i++)
        aItems[i].checked = false; 
    }
</script>