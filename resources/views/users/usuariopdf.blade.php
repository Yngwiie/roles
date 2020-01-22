<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet"> 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    
</head>
<body style="font-family: 'Nunito', sans-serif;">
    <h1 style="left:100px;text-align:center;"><u>Datos del Usuario</u></h1>
    <div style="text-align:center;">
    <table class="table" style="margin: 0 auto;">
        <tbody>
            <tr>
            
                <td ><strong>Nombre:</strong> {{$user->name}}</td>
            </tr>
            <tr>
                <td  ><strong>Rut:</strong> {{$user->rut}}</td>
            </tr>
            <tr>
                <td ><strong>Email:</strong> {{$user->email}}</td>
            </tr>
            <tr>
                <td ><p><strong>Fecha de creación:</strong> {{$user->created_at}}</p></td>
            </tr> 
            <tr>
                <td><p><strong>Habilitado: </strong> 
                    @if(empty($user->deleted_at))
                        Si
                    @else
                        No
                    @endif
                    </p>
                </td>
                
            </tr>    
            <tr>
                <td >
                    <strong>Roles asignados:</strong>
                    <ul class="list-unstyled">
                        @foreach($roles as $role)
                        <li class="list-group-item list-group-item-secondary">
                            <label>
                            <i class="fas fa-angle-double-right"></i>
                                {{$role->name}}
                            </label>
                        </li>
                        @endforeach
                    </ul>
                </td>
            </tr>
        </tbody>
    </table>
    </div>
    <h5 style="left:100px;text-align:center;">Roles y Permisos</h5>
</body>
</html>
