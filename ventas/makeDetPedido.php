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
$pedidoOperador = new PedidosOperaciones();
$detPedidoOperador = new DetPedidoOperaciones();

$totalItems = $detPedidoOperador->getTotalItemsPedido($idPedido);
if ($totalItems < 40) {
    try {
        if ($codProducto > 100000) {
            //PRODUCTOS DE DISTRIBUCIÓN
            $distribucionOperador = new ProductosDistribucionOperaciones();
            $precioProducto = $distribucionOperador->getPrecioVtaProductoDistribucion($codProducto);

        } elseif($codProducto > 10000 && $codProducto < 100000) {
            //PRODUCTOS DE LA EMPRESA
            $presentacionOperador = new PresentacionesOperaciones();
            $precioProducto = $presentacionOperador->getPrecioPresentacion($codProducto, $tipoPrecio);
        }
        $datos = array($idPedido, $codProducto, $cantProducto, $precioProducto);
        $detPedidoOperador->makeDetPedido($datos);
        $_SESSION['idPedido'] = $idPedido;
        $ruta = "det_pedido.php";
        $mensaje = "Detalle del pedido adicionado con éxito";

    } catch (Exception $e) {
        $_SESSION['idPedido'] = $idPedido;
        $ruta = "det_pedido.php";
        $mensaje = "Error al ingresar el detalle del pedido";
    } finally {
        unset($conexion);
        unset($stmt);
        mover_pag($ruta, $mensaje);
    }

} else {
    echo '<script >
        alert("Máximo 40 productos por pedido")
        </script>';
}

