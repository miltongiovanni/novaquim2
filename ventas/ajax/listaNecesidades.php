<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$detPedidoOperador = new DetPedidoOperaciones();
$invProdOperador = new InvProdTerminadosOperaciones();
$invDistOperador = new InvDistribucionOperaciones();
$productos = $detPedidoOperador->getTotalSelPedido($_GET['selPedido']);
$response = [];
for ($i = 0; $i < count($productos); $i++) {
    if ($productos[$i]['codProducto'] < 100000 && $productos[$i]['codProducto'] > 10000) {
        $invProducto = $invProdOperador->getInvTotalProdTerminado($productos[$i]['codProducto']);
        $invListo = $invProdOperador->getInvProdTerminadoListo($productos[$i]['codProducto']);
        if ($invProducto < $productos[$i]['cantidad']) {
            $cantidad = $productos[$i]['cantidad'] - $invProducto + $invListo;
            $response[] = [
                "codProducto" => $productos[$i]['codProducto'],
                "producto" => $productos[$i]['producto'],
                "cantidad" => $cantidad,
            ];
        }
    }
    if ($productos[$i]['codProducto'] > 100000) {
        $invProducto = $invDistOperador->getInvDistribucion($productos[$i]['codProducto']);
        $invListo = $invDistOperador->getInvDistribucionListo($productos[$i]['codProducto']);
        if ($invProducto < $productos[$i]['cantidad']) {
            $cantidad = $productos[$i]['cantidad'] - $invProducto + $invListo;
            $response[] = [
                "codProducto" => $productos[$i]['codProducto'],
                "producto" => $productos[$i]['producto'],
                "cantidad" => $cantidad,
            ];
        }
    }
}

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($response),
    'recordsFiltered' => count($response),
    'data' => $response
);


print json_encode($datosRetorno);


?>