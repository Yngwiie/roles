<div class="form-group">
    {{ Form::label('name','Nombre del usuario') }}
    {{ Form::text('name',null,['class'=>'form-control','required']) }}
</div>

<div class="form-group ">
    <label >
    {{ Form::label('password','Antigua Contraseña')}}
    {{ Form::password('passantigua',null,['class' => 'form-control']) }}
    </label>
</div>

<div class="form-group">
    {{ Form::label('password','Nueva Contraseña')}}
    {{ Form::password('password',null,['class' => 'form-control']) }}
    <i id="mostrar" class="fas fa-eye " style="margin:2px;"></i>
</div>

<div class="form-group">
    {{ Form::label('password_confirmation','Repetir nueva Contraseña')}}
    {{ Form::password('password_confirmation',null,['class' => 'form-control']) }}
    <i id="mostrar_confirmacion" class="fas fa-eye " style="margin:2px;"></i>
</div>

<div >
    {{ Form::submit('Guardar', ['class' =>'btn-sm btn-secondary'])}}
</div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script >
            $(document).ready(function(){
                $('#mostrar').mousedown(function(){
                    $('#password').removeAttr('type');
                });
                $('#mostrar').mouseup(function(){
                    $('#password').attr('type','password');
                });

                $('#mostrar_confirmacion').mousedown(function(){
                    $('#password_confirmation').removeAttr('type');
                });
                $('#mostrar_confirmacion').mouseup(function(){
                    $('#password_confirmation').attr('type','password');
                });

            });
</script>