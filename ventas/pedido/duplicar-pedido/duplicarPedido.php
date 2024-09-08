<?php
include "../../../includes/valAcc.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Habilitar Pedido para Modificar</title>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<?php

$idPedido = $_POST['idPedido'];
$pedidoOperador = new PedidosOperaciones();
$detPedidoOperador = new DetPedidoOperaciones();
$pedido = $pedidoOperador->getPedido($idPedido);
$detPedido = $detPedidoOperador->getDetPedido($idPedido);
$distribucionOperador = new ProductosDistribucionOperaciones();
$presentacionOperador = new PresentacionesOperaciones();
$idUsuario = $_SESSION['userId'];
$estado = 1;
$datos = array($pedido['idCliente'], Fecha::Hoy(), Fecha::Hoy(), $pedido['idPrecio'], $estado, $pedido['idSucursal'], $idUsuario);
try {
    $lastIdPedido = $pedidoOperador->makePedido($datos);
    $_SESSION['idPedido'] = $lastIdPedido;
    $tipoPrecio = $pedido['idPrecio'];
    foreach ($detPedido as $detalle) {
        $codProducto = $detalle['codProducto'];
        $cantProducto = $detalle['cantProducto'];
        if ($codProducto > 100000) {
            //PRODUCTOS DE DISTRIBUCIÓN
            $precioProducto = $distribucionOperador->getPrecioVtaProductoDistribucion($codProducto);

        } elseif($codProducto > 10000 && $codProducto < 100000) {
            //PRODUCTOS DE LA EMPRESA
            $precioProducto = $presentacionOperador->getPrecioPresentacion($codProducto, $tipoPrecio);
        }
        $datos = array($lastIdPedido, $codProducto, $cantProducto, $precioProducto);
        $detPedidoOperador->makeDetPedido($datos);
    }
    $ruta = "../modificar/updatePedidoForm.php";
    $mensaje = "Pedido Duplicado correctamente";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "../consulta-cliente/";
    $mensaje = "Error al duplicar el Pedido";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>

