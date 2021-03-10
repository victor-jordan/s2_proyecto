<?php
require_once(__DIR__ . '\..\controladores\ctrl_usuario.php');
require(__DIR__ . '\..\utiles\limpiar_datos.php');

$controlador = new ctrlUsuario;
$controlador -> obtenerTodos();

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $usuario = new mdlUsuario();

    $usuario -> username = limpiarDatos($_POST['username']);
    $usuario -> nombre = limpiarDatos($_POST['nombre']);
    $usuario -> apellido = limpiarDatos($_POST['apellido']);
    if (isset($_POST['activo'])) {
        $usuario -> activo = true;
    } else{
        $usuario -> activo = false;
    }

    if ($_POST['accion'] == 'insertar') {
        $usuario -> password = limpiarDatos($_POST['password']);
        $resultado = $controlador -> insertarUsuario($usuario);
    } else {
        $usuario -> id = limpiarDatos($_POST['id']);
        $resultado = $controlador -> modificarUsuario($usuario);
    }
}
?>
<!DOCTYPE html>
<html lang="es-ES">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/mvp.css/1.6.3/mvp.min.css">
    <title>Usuarios</title>
    <style>
        .mensaje{
            background-color: red;
            float: right;
        }
    </style>
</head>
<body>
<div class="mensaje">
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo $resultado;
    // refrescamos la cabecera de la pagina
    header("Refresh:4");
}
?>
</div>
<div style="float: left;" width="50%">
<form action="" method="POST" action="">
    <h3 id="titulo_formulario">Agregar Usuario</h3>
    <label for="username">Username<input type="text" name="username" required></label>
    <label for="password">Password<input type="password" name="password" required></label>
    <label for="nombre">Nombre<input type="text" name="nombre"></label>
    <label for="apellido">Apellido<input type="text" name="apellido"></label>
    <label for="activo">Activo<input type="checkbox" name="activo" checked></label>
    <!-- Campos escondidos para manejar la acción y el identificador del elemento -->
    <input type="hidden" id="identificador" name="id" value="">
    <input type="hidden" id="accion" name="accion" value="insertar">
    <button id="boton_envio">Insertar</button>
</form>
</div>
<div style="float: left;" width="50%">
<table>
    <caption><h4>Listado de usuarios</h4></caption>
    <thead><tr><th>#</th><th>Username</th><th>Nombre</th><th>Apellido</th><th>Activo</th></tr></thead>
    <tbody>
<?php
    foreach ($controlador -> usuarios as $usuario) {
        echo "<tr onclick='javascript:llenarForm(this);'><td>" . $usuario -> id . "</td>" . "<td>" . $usuario -> username . "</td>"  . "<td>" . $usuario -> nombre . "</td>"  . "<td>" . $usuario -> apellido . "</td>" . "<td>" . (($usuario -> activo) ? "✓" : "✗") . "<span style='display:none;'>" . (($usuario -> activo) ? "1" : "0") . "</span></td></tr>";
    }
$controlador = null;
?>
    </tbody>
</table>
</div>
</body>
<script type="text/javascript">
    function llenarForm(row){
        var fila=row.cells;
        document.getElementById("identificador").value = fila[0].innerHTML
        document.getElementsByName("username")[0].value = fila[1].innerHTML;
        document.getElementsByName("password")[0].disabled = true;
        document.getElementsByName("nombre")[0].value = fila[2].innerHTML;
        document.getElementsByName("apellido")[0].value = fila[3].innerHTML;
        // console.log(fila[4].childNodes[1].childNodes[0].data)
        // Se toma el valor del span escondido y que es hijo (childNode) de segundo nivel de la fila
        if (fila[4].childNodes[1].childNodes[0].data == '1') {
            document.getElementsByName("activo")[0].checked = true;
        } else{
            document.getElementsByName("activo")[0].checked = false;
        }
        document.getElementById("accion").value = "modificar";
        document.getElementById("boton_envio").innerHTML = "Modificar";
        document.getElementById("titulo_formulario").innerHTML = "Modificar Usuario Nº " + fila[0].innerHTML;
    }
</script>
</html>