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


$remisionOperador = new RemisionesOperaciones();
$detRemisionOperador = new DetRemisionesOperaciones();
$detPedidoOperador = new DetPedidoOperaciones();
$invProdTerminadoOperador = new InvProdTerminadosOperaciones();
$invDistribucionOperador = new InvDistribucionOperaciones();
$pedidoOperador = new PedidosOperaciones();
$fecha_actual = hoy();
$dias_remision = Calc_Dias($fechaRemision, $fecha_actual);
if (($dias_remision >= 0)) {
    try {
        /*CREACIÓN DEL ENCABEZADO DE LA REMISIÓN*/
        $datos = array($idCliente, $fechaRemision, $idPedido, $idSucursal);
        $idRemision = $remisionOperador->makeRemisionFactura($datos);

        //CON BASE EN EL PEDIDO SE LLENA LA FACTURA
        $detPedido = $detPedidoOperador->getDetPedidoRemision($idPedido);
        for ($i = 0; $i < count($detPedido); $i++) {
            $codProducto = $detPedido[$i]['codProducto'];
            $cantidad = $detPedido[$i]['cantProducto'];
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
            } elseif ($codProducto > 100000) {
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
        }
        //CALCULA LOS TOTALES DE IVA, DESCUENTO

        $pedidoOperador->updateEstadoPedido('E', $idPedido);
        $_SESSION['idRemision'] = $idRemision;
        $ruta = "det_remision.php";
        $mensaje = "Remisión creada con éxito";
        $icon = "success";
    } catch (Exception $e) {
        $ruta = "crearRemision.php";
        $mensaje = "Error al crear la Remisión";
        $icon = "error";
    } finally {
        unset($conexion);
        unset($stmt);
        mover_pag($ruta, $mensaje, $icon);
    }
} else {
    if ($dias_remision < 0) {
        $ruta = "crearRemision.php";
        $mensaje = "La fecha de la remisión no puede ser menor que la fecha actual";
        $icon = "error";
        mover_pag($ruta, $mensaje, $icon);
    }
}
?>
</body>
</html>
