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
?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <title>Factura de Venta</title>
        <meta charset="utf-8">
        <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
        <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
        <script src="../js/validar.js"></script>
    </head>
    <body>
<?php
$tasaDescuento = $descuento / 100;
$pedidosList = explode(',', $idPedido);
$facturaOperador = new FacturasOperaciones();
$detFacturaOperador = new DetFacturaOperaciones();
$detPedidoOperador = new DetPedidoOperaciones();
$pedidoOperador = new PedidosOperaciones();
if ($facturaOperador->isValidIdFactura($idFactura)) {
    $ruta = "CrearFactura.php";
    $mensaje = "Número de factura ya existe, intente de nuevo";
    $icon = "warning";
    mover_pag($ruta, $mensaje, $icon);
    exit;
}
$fecha_actual = hoy();
$dias_v = Calc_Dias($fechaVenc, $fecha_actual);
$dias_f = Calc_Dias($fechaVenc, $fechaFactura);

if (($dias_v >= 0) && ($dias_f >= 0)) {
    try {
        /*CREACIÓN DEL ENCABEZADO DE LA FACTURA*/
        $datos = array($idFactura, $idPedido, $idCliente, $fechaFactura, $fechaVenc, $tipPrecio, 'E', $idRemision, $ordenCompra, $tasaDescuento, $observaciones);
        $facturaOperador->makeFactura($datos);
        //CON BASE EN EL PEDIDO SE LLENA LA FACTURA
        $detPedido = $detPedidoOperador->getTotalPedidosPorFacturar($idPedido);
        for ($i = 0; $i < count($detPedido); $i++) {
            $codProducto = $detPedido[$i]['codProducto'];
            $cantidad = $detPedido[$i]['cantidad'];
            $precio = $detPedido[$i]['precio'];
            $codIva = $detPedido[$i]['codIva'];
            /*SE ADICIONA A LA FACTURA*/
            $datos = array($idFactura, $codProducto, $cantidad, $precio, $codIva);
            $detFacturaOperador->makeDetFactura($datos);
        }

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
        foreach ($pedidosList as $pedido){
            $pedidoOperador->updateEstadoPedido(4, $pedido);
        }
        $_SESSION['idFactura'] = $idFactura;
        $ruta = "det_factura.php";
        $mensaje = "Factura creada con éxito";
        $icon = "success";
    } catch (Exception $e) {
        $ruta = "crearFactura.php";
        $mensaje = "Error al crear la Factura";
        $icon = "error";
    } finally {
        unset($conexion);
        unset($stmt);
        mover_pag($ruta, $mensaje, $icon);
    }
} else {
    if ($dias_v < 0) {
        $ruta = "crearFactura.php";
        $mensaje = "La fecha de vencimiento de la factura no puede ser menor que la fecha actual";
        $icon = "error";
        mover_pag($ruta, $mensaje, $icon);
    }
    if ($dias_f < 0) {
        $ruta = "crearFactura.php";
        $mensaje = "La fecha de vencimiento de la factura no puede ser menor que la fecha de la factura";
        $icon = "error";
        mover_pag($ruta, $mensaje, $icon);
    }
}
?>
    </body>
</html>
