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
$remisionOperador = new RemisionesOperaciones();
$detRemisionOperador = new DetRemisionesOperaciones();
$detPedidoOperador = new DetPedidoOperaciones();
$invProdTerminadoOperador = new InvProdTerminadosOperaciones();
$invDistribucionOperador = new InvDistribucionOperaciones();
$pedidoOperador = new PedidosOperaciones();
if ($facturaOperador->isValidIdFactura($idFactura)) {
    $ruta = "CrearFactura.php";

    $mensaje = "Número de factura ya existe, intente de nuevo";
    mover_pag($ruta, $mensaje, $icon);
}
$fecha_actual = hoy();
$dias_v = Calc_Dias($fechaVenc, $fecha_actual);
$dias_f = Calc_Dias($fechaVenc, $fechaFactura);
if (($dias_v >= 0) && ($dias_f >= 0)) {
    try {
        /*CREACIÓN DEL ENCABEZADO DE LA REMISIÓN*/
        $datos = array($idCliente, $fechaFactura, $idPedido, $idSucursal);
        $idRemision=$remisionOperador->makeRemisionFactura($datos);

        /*CREACIÓN DEL ENCABEZADO DE LA FACTURA*/
        $datos = array($idFactura, $idPedido, $idCliente, $fechaFactura, $fechaVenc, $tipPrecio, 'E', $idRemision, $ordenCompra, $tasaDescuento, $observaciones);
        $facturaOperador->makeFactura($datos);
        //CON BASE EN EL PEDIDO SE LLENA LA FACTURA
        $detPedido = $detPedidoOperador->getDetPedidoFactura($idPedido);
        for ($i = 0; $i < count($detPedido); $i++) {
            $codProducto = $detPedido[$i]['codProducto'];
            $cantidad = $detPedido[$i]['cantProducto'];
            $precio = $detPedido[$i]['precio'];
            $codIva = $detPedido[$i]['codIva'];
            /*DESCARGA DEL INVENTARIO*/
            $unidades = $cantidad;
            if (($codProducto < 100000) && ($codProducto > 100)) {
                $invProdTerminado = $invProdTerminadoOperador->getInvProdTerminado($codProducto);
                for ($j = 0; $j < count($invProdTerminado); $j++) {
                    $inv = $invProdTerminado[$j]['invProd'];
                    $lote = $invProdTerminado[$j]['loteProd'];
                    if (($inv >= $unidades)) {
                        $nvoInv = $inv - $unidades;
                        /*SE ADICIONA A LA REMISIÓN*/
                        $datos = array($idRemision, $codProducto, $unidades, $lote);
                        $detRemisionOperador->makeDetRemisionFactura($datos);
                        $unidades = 0;
                        /*SE ACTUALIZA EL INVENTARIO*/
                        $datos = array($nvoInv, $codProducto, $lote);
                        $invProdTerminadoOperador->updateInvProdTerminado($datos);
                        break;
                    } else {
                        $unidades = $unidades - $inv;
                        /*SE ACTUALIZA EL INVENTARIO*/
                        $datos = array(0, $codProducto, $lote);
                        $invProdTerminadoOperador->updateInvProdTerminado($datos);
                        /*SE ADICIONA A LA REMISIÓN*/
                        $datos = array($idRemision, $codProducto, $inv, $lote);
                        $detRemisionOperador->makeDetRemisionFactura($datos);
                    }
                }
            }elseif ($codProducto > 100000) {
                //PRODUCTOS DE DISTRIBUCIÓN
                $invDistribucionOperador = new InvDistribucionOperaciones();
                $invDistribucion = $invDistribucionOperador->getInvDistribucion($codProducto);
                $nvoInvDistribucion = $invDistribucion - $cantidad;
                /*SE ACTUALIZA EL INVENTARIO*/
                $datos = array($nvoInvDistribucion, $codProducto);
                $invDistribucionOperador->updateInvDistribucion($datos);
                /*SE ADICIONA A LA REMISIÓN*/
                $datos = array($idRemision, $codProducto, $cantidad, 0);
                $detRemisionOperador->makeDetRemisionFactura($datos);
            }
            /*SE ADICIONA A LA FACTURA*/
            $datos = array($idFactura, $codProducto, $cantidad, $precio, $codIva);
            $detFacturaOperador->makeDetFactura($datos);
        }

        //CALCULA LOS TOTALES DE IVA, DESCUENTO
        $totales = calcularTotalesFactura($idFactura, $tasaDescuento);
        $subtotal= $totales['subtotal'];
        $descuento= $totales['descuento'];
        $iva10Real= $totales['iva10Real'];
        $iva16Real= $totales['iva16Real'];
        $iva= $totales['iva'];
        $reteiva= $totales['reteiva'];
        $retefuente= $totales['retefuente'];
        $reteica= $totales['reteica'];
        $total = $subtotal - $descuento + $iva - $reteiva - $retefuente - $reteica;
        $totalR = round($subtotal - $descuento + $iva);
        $datos = array($total, $reteiva, $reteica, $retefuente, $subtotal, $iva, $totalR, $idFactura);
        $facturaOperador->updateTotalesFactura($datos);
        $pedidoOperador->updateEstadoPedido('F', $idPedido);
        $_SESSION['idFactura'] = $idFactura;
        $ruta = "det_factura.php";
        $mensaje = "Factura creada con éxito";
    }catch (Exception $e){
        $ruta = "crearFactura.php";
        $mensaje = "Error al crear la Factura";
    } finally
    {
        unset($conexion);
        unset($stmt);
        mover_pag($ruta, $mensaje, $icon);
    }
} else {
    if ($dias_v < 0) {
        echo '<script >
		alert("La fecha de vencimiento de la factura no puede ser menor que la fecha actual");
		self.location="crearFactura.php";
		</script>';
    }
    if ($dias_f < 0) {
        echo '<script >
		alert("La fecha de vencimiento de la factura no puede ser menor que la fecha de la factura");
		self.location="crearFactura.php";
		</script>';
    }
}
