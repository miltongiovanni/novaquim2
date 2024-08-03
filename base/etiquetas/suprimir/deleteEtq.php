<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$codEtiqueta = $_POST['codEtiqueta'];
$EtiquetaOperador = new EtiquetasOperaciones();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Eliminar Etiqueta</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<?php

try {
    $EtiquetaOperador->deleteEtiqueta($codEtiqueta);
    $ruta = "../lista/";
    $mensaje = "Etiqueta eliminada correctamente";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "../suprimir/";
    $mensaje = "Error al eliminar la etiqueta";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>
