<?php
include "../includes/valAcc.php";
foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if (is_array($valor)) {
        //echo $nombre_campo.print_r($valor).'<br>';
    } else {
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
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
    <title>Actualizar detalle orden de producción materia prima</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<?php
$DetOProdMPrimaOperador = new DetOProdMPrimaOperaciones();
$InvMPrimaOperador = new InvMPrimasOperaciones();
$datos = array($cantMPrima, $loteMP, $idMPrima);
try {
    $DetOProdMPrimaOperador->updateDetOProdMPrimas($datos);
    $invMPrima = $InvMPrimaOperador->getInvMPrimaByLote($idMPrima, $loteMPrima);
    $nvoInvMPrima = $invMPrima + $cantidad_ant - $cantMPrima;
    $datos = array($nvoInvMPrima, $idMPrima, $loteMPrima);
    $InvMPrimaOperador->updateInvMPrima($datos);
    $_SESSION['loteMP'] = $loteMP;
    $ruta = "detO_Prod_MP.php";
    $mensaje = "Detalle orden de producción de materia prima actualizado correctamente";
    $icon = "success";
} catch (Exception $e) {
    $_SESSION['loteMP'] = $loteMP;
    $ruta = "detO_Prod_MP.php";
    $mensaje = "Error al actualizar el detalle orden de producción de materia prima";
    $icon = "error";
} finally {
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>
