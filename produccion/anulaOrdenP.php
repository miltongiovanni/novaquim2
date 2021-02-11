<?php
include "../includes/valAcc.php";
$lote = $_POST['lote'];
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
    <title>Seleccionar Orden de Producción a Anular</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<?php
$OProdOperador = new OProdOperaciones();
$DetOProdOperador = new DetOProdOperaciones();
$InvMPrimaOperador = new InvMPrimasOperaciones();

try {
    $detalle = $DetOProdOperador->getTableDetOProd($lote);
    for ($i = 0; $i < count($detalle); $i++) {
        $invMPrima = $InvMPrimaOperador->getInvMPrimaByLote($detalle[$i]['codMPrima'], $detalle[$i]['loteMP']);
        $nvoInvMPrima = $invMPrima + $detalle[$i]['cantidadMPrima'];
        $datos = array($nvoInvMPrima, $detalle[$i]['codMPrima'], $detalle[$i]['loteMP']);
        $InvMPrimaOperador->updateInvMPrima($datos);
    }
    $DetOProdOperador->deleteDetOProd($lote);
    $OProdOperador->anulaOProd($lote);
    $ruta = "listarOrProdA.php";
    $mensaje = "Orden de Producción Anulada con Éxito";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "../menu.php";
    $mensaje = "Error al anular Orden de Producción";
    $icon = "error";
} finally {
    mover_pag($ruta, $mensaje, $icon);
}

?>
</body>
</html>