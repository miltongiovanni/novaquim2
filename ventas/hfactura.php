<?php
include "../includes/valAcc.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idPedido = $_POST['idPedido'];
$pedidoOperador = new PedidosOperaciones();
try {
    $pedidoOperador->updateEstadoPedido('P', $idPedido);
    $ruta = "../menu.php";
    $mensaje = "Pedido Habilitado para modificar correctamente";

} catch (Exception $e) {
    $ruta = "../menu.php";
    $mensaje = "Error al habilitar el Pedido";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}



