<?php
include "../../../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$codPresentacion = $_POST['codPresentacion'];
$PresentacionOperador = new PresentacionesOperaciones();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Eliminar presentación de producto</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>

<body>
<?php
try {
    $PresentacionOperador->deletePresentacion($codPresentacion);
    $ruta = "/base/presentaciones/lista";
    $mensaje = "Presentación eliminada correctamente";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "/base/presentaciones/suprimir";
    $mensaje = "Error al eliminar la presentación";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>

