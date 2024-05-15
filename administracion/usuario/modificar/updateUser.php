<?php
include "../../../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if (is_array($valor)) {
        //echo $nombre_campo.print_r($valor).'<br>';
    } else {
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Actualizar datos del Usuario</title>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>

<body>
<?php

$fecCambio = Fecha::Hoy();
$intentos = 0;
$datos = array($nombre, $apellido, $usuario, $estadoUsuario, $idPerfil, $fecCambio, $intentos, $email, $idUsuario);
$usuarioOperador = new UsuariosOperaciones();

try {
    $usuarioOperador->updateUser($datos);
    $ruta = "/administracion/usuario/lista";
    $mensaje = "Usuario Actualizado correctamente";
    $icon = 'success';
} catch (Exception $e) {
    $ruta = "/administracion/usuario/modificar";
    $mensaje = "Error al actualizar al usuario";
    $icon = 'error';
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}


?>
</body>
</html>