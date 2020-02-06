
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

<div id="especiales" class="form-group">

    <label >{{ Form::radio('special','all-access',false,array('id'=>'acceso_total','onchange')) }}Acceso Total</label>
    <label >{{ Form::radio('special','no-access',false,array('id'=>'sin_acceso')) }}Ningun Acceso </label>
    <input class="btn btn-secondary btn-sm" id="deseleccionar"type="button" name="res" value="Deseleccionar" onclick="unselect()"> 
</div>
<h3>Lista de permisos</h3>
<div id="permisos" class="form-group" style="display:inline;">
    <ul class="list-unstyled">
        <?php $i=0;?>
        @foreach($permissions as $permission)
        <li>
            <label>
                
                {{ Form::checkbox('permissions[]',$permission->id,null,array('id'=>'permiso'.$i+=1)) }}
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
        /* $('#acceso_total').prop()
        var discounted = document.getElementById('acceso_total');
        var discount_percentage = document.getElementById('permisos')
        if (discounted.checked) {
            console.log("hola");
            discount_percentage.disabled = true;
        } else {
            console.log("chao");
            discount_percentage.disabled = false;
        } */
    });
    function comprobar(obj){
        if(obj.checked){

        }
    }
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
<script>
    if($("#acceso_total").is(":checked")){
        var aItems = document.getElementsByName("permissions[]");
        for (var i = 0; i < aItems.length; i++)
            aItems[i].disabled = true; 
    }
    if($("#sin_acceso").is(":checked")){
        var aItems = document.getElementsByName("permissions[]");
        for (var i = 0; i < aItems.length; i++)
            aItems[i].disabled = true; 
    }
    $("#acceso_total").click(function(){
        var aItems = document.getElementsByName("permissions[]");
        for (var i = 0; i < aItems.length; i++)
            aItems[i].disabled = true; 
    });
    $("#sin_acceso").click(function(){
        var aItems = document.getElementsByName("permissions[]");
        for (var i = 0; i < aItems.length; i++)
            aItems[i].disabled = true; 
    });
    $("#deseleccionar").click(function(){
        console.log("hola");
        var aItems = document.getElementsByName("permissions[]");
            for (var i = 0; i < aItems.length; i++)
                aItems[i].disabled = false; 
    });

</script>