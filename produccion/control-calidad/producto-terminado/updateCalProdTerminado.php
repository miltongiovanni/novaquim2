<?php
include "../../../includes/valAcc.php";
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
    <title>Control de calidad orden de producción</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>

</head>
<body>
<?php
$datos = array( $etiquetado, $envasado, $observaciones, $lote);
$calProdTerminadoOperador = new CalProdTerminadoOperaciones();

try {
    $calProdTerminadoOperador->updateCalProdTerminado($datos);
    $ruta = "det_cal_prod_terminado.php";
    $mensaje = "Control de Calidad producto terminado actualizado correctamente";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "../producto-terminado/";
    $mensaje = "Error al actualizar el control de calidad producto terminado";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}

?>
</body>
</html>



