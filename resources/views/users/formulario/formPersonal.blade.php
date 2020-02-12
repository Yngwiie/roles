<div class="form-group row">
    {{ Form::label('name','Nombre del usuario',['class'=>'col-md-4 col-form-label text-md-right']) }}
    <div class="col-md-6">
        {{ Form::text('name',null,['class'=>'form-control','required']) }}
    </div>
</div>

<div class="form-group row">
    
    {{ Form::label('password','Contraseña Antigua',['class'=>'col-md-4 col-form-label text-md-right'])}}
    <div class="col-md-6">
        {{ Form::password('passantigua',['class' => 'form-control']) }}
    </div>
</div>

<div class="form-group row">
    {{ Form::label('password','Contraseña Nueva',['class'=>'col-md-4 col-form-label text-md-right'])}}
    <div class="col-md-6">
        {{ Form::password('password',['class' => 'form-control','placeholder'=>'Debe contener al menos 8 caracteres']) }}
        
    </div>
    <i id="mostrar" ontouchend="dejarMos()" ontouchstart="mostrarCon()" class="fas fa-eye " style="margin:2px;padding-top:10px"></i>
</div>

<div class="form-group row">
    {{ Form::label('password_confirmation','Repetir Contraseña Nueva',['class'=>'col-md-4 col-form-label text-md-right'])}}
    <div class="col-md-6">
        {{ Form::password('password_confirmation',['class' => 'form-control','placeholder'=>'Debe contener al menos 8 caracteres']) }}
    </div>
    <i id="mostrar_confirmacion" ontouchend="dejarMostrarConfirm()" ontouchstart="mostrarConfirm()" class="fas fa-eye " style="margin:2px;padding-top:10px"></i>
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
            function mostrarConfirm(){
                $('#password_confirmation').removeAttr('type');
            }
            function dejarMostrarConfirm(){
                $('#password_confirmation').attr('type','password');
            }
            function mostrarCon(){
                $('#password').removeAttr('type');
            }
            function dejarMos(){
                $('#password').attr('type','password');
            }
</script>