<?php
include "../../../includes/valAcc.php";
foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if(is_array($valor)){
        //echo $nombre_campo.print_r($valor).'<br>';
    }else{
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar datos de detalle orden de producción</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<?php
$DetOProdOperador = new DetOProdOperaciones();
$InvMPrimaOperador = new InvMPrimasOperaciones();
$datos = array($cantidadMPrima, $lote, $codMPrima);

try {
    $DetOProdOperador->updateDetOProd($datos);
    $invMPrima = $InvMPrimaOperador->getInvMPrimaByLote($codMPrima, $loteMP);
    $nvoInvMPrima = $invMPrima + $cantidad_ant - $cantidadMPrima;
    $datos = array($nvoInvMPrima, $codMPrima, $loteMP);
    $InvMPrimaOperador->updateInvMPrima($datos);
    $_SESSION['lote'] = $lote;
    $ruta = "../detalle/";
    $mensaje = "Detalle Orden de Producción actualizado correctamente";
    $icon = "success";
} catch (Exception $e) {
    $_SESSION['lote'] = $lote;
    $ruta = "../detalle/";
    $mensaje = "Error al actualizar Orden de Producción";
    $icon = "error";
} finally {
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>