<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$idPedido = $_POST['idPedido'];
$pedidoOperador = new PedidosOperaciones();
$detPedidoOperador = new DetPedidoOperaciones();
try {
    $pedidoOperador->updateEstadoPedido('A', $idPedido);
    $detPedidoOperador->deleteAllDetPedido($idPedido);
    $ruta = "listarPedidoA.php";
    $mensaje = "Orden de pedido anulada con éxito";

} catch (Exception $e) {
    $ruta = "../menu.php";
    $mensaje = "Error al anular la orden de pedido";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
