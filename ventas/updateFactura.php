<?php
include "../includes/valAcc.php";
include "../includes/calcularDias.php";
include "../includes/ventas.php";
foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if (is_array($valor)) {
        //echo $nombre_campo.print_r($valor).'<br>';
    } else {
        //echo $nombre_campo . '=' . ${$nombre_campo} . '<br>';
    }
}


$tasaDescuento = $descuento / 100;
$facturaOperador = new FacturasOperaciones();
$detFacturaOperador = new DetFacturaOperaciones();



$fecha_actual = hoy();
$dias_v = Calc_Dias($fechaVenc, $fecha_actual);
$dias_f = Calc_Dias($fechaVenc, $fechaFactura);
if (($dias_v >= 0) && ($dias_f >= 0)) {
    try {
        $datos = array($fechaFactura, $fechaVenc, $tipPrecio, $tasaDescuento, $idFactura);
        $facturaOperador->updateFactura($datos);
        //CALCULA LOS TOTALES DE IVA, DESCUENTO
        $totales = calcularTotalesFactura($idFactura, $tasaDescuento);
        $subtotal = $totales['subtotal'];
        $descuento = $totales['descuento'];
        $iva10Real = $totales['iva10Real'];
        $iva16Real = $totales['iva16Real'];
        $iva = $totales['iva'];
        $reteiva = $totales['reteiva'];
        $retefuente = $totales['retefuente'];
        $reteica = $totales['reteica'];
        $total = $subtotal - $descuento + $iva - $reteiva - $retefuente - $reteica;
        $totalR = round($subtotal - $descuento + $iva);
        $datos = array($total, $reteiva, $reteica, $retefuente, $subtotal, $iva, $totalR, $idFactura);
        $facturaOperador->updateTotalesFactura($datos);
        $_SESSION['idFactura'] = $idFactura;
        $ruta = "det_factura.php";
        $mensaje = "Factura actualizada con éxito";
    } catch (Exception $e) {
        $ruta = "buscarFactura.php";
        $mensaje = "Error al actualizar la Factura";
    } finally {
        unset($conexion);
        unset($stmt);
        mover_pag($ruta, $mensaje, $icon);
    }
} else {
    if ($dias_v < 0) {
        echo '<script >
		alert("La fecha de vencimiento de la factura no puede ser menor que la fecha actual");
		self.location="buscarFactura.php";
		</script>';
    }
    if ($dias_f < 0) {
        echo '<script >
		alert("La fecha de vencimiento de la factura no puede ser menor que la fecha de la factura");
		self.location="buscarFactura.php";
		</script>';
    }
}
