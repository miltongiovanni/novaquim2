<?php
include "../includes/valAcc.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
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
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <title>Creación de Usuarios</title>
    <meta charset="utf-8">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>

<body>
<?php
$usuario = strtoupper($_POST['usuario']);
$estadoUsuario = 1;
$fecCambio = Fecha::Hoy();
$fecCrea = Fecha::Hoy();
$intentos = 0;
$clave = md5($usuario);
$datos = array($nombre, $apellido, $usuario, $clave, $estadoUsuario, $idPerfil, $fecCrea, $fecCambio, $intentos);
$usuarioOperador = new UsuariosOperaciones();

try {
    $lastIdUser = $usuarioOperador->makeUser($datos);
    $ruta = "listarUsuarios.php";
    $mensaje = "Usuario Creado correctamente";
    $icon = 'success';
} catch (Exception $e) {
    $ruta = "makeUserForm.php";
    $mensaje = "Error al crear el usuario";
    $icon = 'error';
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>

