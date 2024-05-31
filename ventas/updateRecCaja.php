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
        //echo $nombre_campo . '=' . ${$nombre_campo} . '<br>';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Actualizar Recibo de caja</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<?php
$datos = array($cobro, $fechaRecCaja, $descuento_f, $form_pago, $reten, $idCheque, $codBanco, $reten_ica, $idRecCaja);
$recCajaOperador = new RecCajaOperaciones();
$facturaOperador =  new FacturasOperaciones();
$recibo = $recCajaOperador->getRecCaja($idRecCaja);
$abono = $recCajaOperador->getCobrosAnterioresFactura($recibo['idFactura'], $idRecCaja);
$abono = $abono==null ? 0 : $abono;
if (round($recibo['totalR'] - $recibo['retencionFte'] - $recibo['retencionIca'] - $recibo['retencionIva'] - $abono - $cobro) < 0) {
    $ruta = "recibo_caja.php";
    $mensaje = "El pago sobrepasa el valor de la factura";
    $icon = "warning";
    mover_pag($ruta, $mensaje, $icon);
} else {
    try {
        $recCajaOperador->updateRecCaja($datos);
        if (abs($recibo['totalR'] - $recibo['retencionFte'] - $recibo['retencionIca'] - $recibo['retencionIva'] - $abono - $cobro) < 100) {
            $facturaOperador->cancelarFactura($fechaRecCaja, $recibo['idFactura']);
        }
        $ruta = "recibo_caja.php";
        $mensaje = "Recibo de caja actualizado correctamente";
        $icon = "success";
    } catch (Exception $e) {
        $ruta = "recibo_caja.php";
        $mensaje = "Error al actualizar el recibo de caja";
        $icon = "error";
    } finally {
        unset($conexion);
        unset($stmt);
        mover_pag($ruta, $mensaje, $icon);
    }
}
?>
</body>
</html>
