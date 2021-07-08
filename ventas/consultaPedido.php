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
if (!$pedidoOperador->isValidIdPedido($idPedido)) {
    $ruta = "seleccionarPedido.php";
    $mensaje = "El número del pedido no es válido, vuelva a intentar de nuevo";
    $icon = "warning";
    mover_pag($ruta, $mensaje, $icon);
    exit;
} else {
    $_SESSION['idPedido'] = $idPedido;
    $ruta = "det_pedido.php";
    $mensaje = "El número del pedido es válido";
    $icon = "success";
    mover_pag($ruta, $mensaje, $icon);
    exit;
}
