<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idPersonal = $_POST['idPersonal'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Borrar Personal</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<?php
$personalOperador = new PersonalOperaciones();

try {
    $personalOperador->deletePersonal($idPersonal);
    $ruta = "listarPersonal.php";
    $mensaje = "Personal borrado correctamente";
    $icon = 'success';

} catch (Exception $e) {
    $ruta = "../menu.php";
    $mensaje = "Error al borrar al personal";
    $icon = 'error';
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>
