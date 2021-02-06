<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Eliminar Envase</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>


<body>
<?php
$codEnvase = $_POST['codEnvase'];
$EnvaseOperador = new EnvasesOperaciones();


try {
    $EnvaseOperador->deleteEnvase($codEnvase);
    $ruta = "listarEnv.php";
    $mensaje = "Envase eliminado correctamente";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "../menu.php";
    $mensaje = "Error al eliminar el envase";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}


?>

</body>
</html>
