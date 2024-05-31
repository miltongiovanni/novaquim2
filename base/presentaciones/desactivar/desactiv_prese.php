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
    <title>Seleccionar Presentación de Producto a desactivar</title>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>

<body>

<?php
$datos = array(0, $codPresentacion);
$PresentacionOperador = new PresentacionesOperaciones();

try {
    $PresentacionOperador->activarDesactivarPresentacion($datos);
    $ruta = "/base/presentaciones/lista";
    $mensaje = "Presentación desactivada correctamente";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "/base/presentaciones/desactivar";
    $mensaje = "Error al desactivar la presentación";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>
