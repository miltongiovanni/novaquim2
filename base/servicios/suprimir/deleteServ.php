<?php
include "../../../includes/valAcc.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idServicio = $_POST['idServicio'];
$servicioperador = new ServiciosOperaciones();
?>

<!DOCTYPE html>
<html lang="es">
<head><link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">

    <meta charset="utf-8">
    <title>Seleccionar Servicio a eliminar</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script  src="../../../js/validar.js"></script>
</head>
<body>

<?php
try {
    $servicioperador->deleteServicio($idServicio);
    $ruta = "../lista/";
    $mensaje = "Servicio eliminado correctamente";
    $icon = "success";

} catch (Exception $e) {
    $ruta = "../suprimir/";
    $mensaje = "No fue permitido eliminar el Servicio";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}

?>
</body>
</html>