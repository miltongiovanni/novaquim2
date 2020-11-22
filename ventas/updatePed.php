<?php
include "../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
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
$detPedidoOperador = new DetPedidoOperaciones();
$datos = array($cantProducto, $precioProducto, $idPedido, $codProducto);
try {
    $detPedidoOperador->updateDetPedido($datos);
    $_SESSION['idPedido'] = $idPedido;
    $ruta = "det_pedido.php";
    $mensaje = "Detalle del pedido actualizado con éxito";

} catch (Exception $e) {
    $_SESSION['idPedido'] = $idPedido;
    $ruta = "det_pedido.php";
    $mensaje = "Error al actualizar el detalle del pedido";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}
