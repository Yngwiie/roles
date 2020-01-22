
<div class="form-group">
    {{ Form::label('name','Nombre') }}
    {{ Form::text('name',null,['class'=>'form-control','required']) }}
</div>

<div class="form-group">
    {{ Form::label('slug','URL amigable')}} 
    <span class="d-inline-block" data-placement="right" tabindex="0" data-toggle="tooltip" title="Este atributo sirve para idenfiticar internamente el rol, debe ser unico.">
        <button class="btn " data-placement="right" style="pointer-events: none;" type="button" disabled><i class="far fa-question-circle fa-lg"></i></button>
    </span>
    {{ Form::text('slug',null,['class' => 'form-control','required']) }}
    <input type="button" class="btn btn-success btn-sm" name="btnGenerarUrl" id="btnGenerarUrl" value="Copiar nombre">
</div>

<div class="form-group">
    {{ Form::label('description','Descripción') }}
    {{ Form::textarea('description',null,['class'=>'form-control']) }}
</div>
<hr>

<h3 class="d-inline-block">Permisos Especiales</h3>
<span class="d-inline-block" data-placement="right" tabindex="0" data-toggle="tooltip" title="Evite marcar este atributo si desea solo permisos especificos, ya que no se tomaran en cuenta si marca un permiso especial.">
    <button class="btn " data-placement="right" style="pointer-events: none;" type="button" disabled><i class="far fa-question-circle fa-lg"></i></button>
</span>

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
<script >
    $(document).ready(function(){
        $("#btnGenerarUrl").click(function (){
            var x = slugify($("#name").val());
            $("#slug").val(x);
        });
    });

    function slugify(text){
      return text.toString().toLowerCase()
        .replace(/\s+/g, '-')           // Replace spaces with -
        .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
        .replace(/\-\-+/g, '-')         // Replace multiple - with single -
        .replace(/^-+/, '')             // Trim - from start of text
        .replace(/-+$/, '');            // Trim - from end of text
    }
</script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>