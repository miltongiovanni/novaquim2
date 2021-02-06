<?php
include "../includes/valAcc.php";

function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$codTapa = $_POST['codTapa'];
$TapaOperador = new TapasOperaciones();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Eliminar Tapa o Válvula</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>

<body>

<?php

try {
    $TapaOperador->deleteTapa($codTapa);
    $ruta = "listarVal.php";
    $mensaje = "Tapa o válvula eliminada correctamente";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "deleteValForm.php";
    $mensaje = "Error al eliminar la tapa o válvula";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}


?>
</body>
</html>