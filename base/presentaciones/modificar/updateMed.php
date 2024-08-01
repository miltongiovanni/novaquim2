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
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar datos de Presentación de Producto</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>

<body>

<?php
$datos = array($presentacion, $codEnvase, $codTapa, $codEtiq, $codigoGen, $stockPresentacion, $cotiza, $codPresentacion);
$PresentacionOperador = new PresentacionesOperaciones();

try {
    $PresentacionOperador->updatePresentacion($datos);
    $ruta = "/base/presentaciones/lista";
    $mensaje = "Presentación actualizada correctamente";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "/base/presentaciones/modificar";
    $mensaje = "Error al actualizar la presentación";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>