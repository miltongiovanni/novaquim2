<?php
include "../../../includes/valAcc.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Detalle de Orden de Pedido</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<?php
$pedidoOperador = new PedidosOperaciones();
$detPedidoOperador = new DetPedidoOperaciones();

$totalItems = $detPedidoOperador->getTotalItemsPedido($idPedido);
if ($totalItems < 50) {
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
        $icon = "success";

    } catch (Exception $e) {
        $_SESSION['idPedido'] = $idPedido;
        $ruta = "det_pedido.php";
        $mensaje = "Error al ingresar el detalle del pedido";
        $icon = "error";
    } finally {
        unset($conexion);
        unset($stmt);
        mover_pag($ruta, $mensaje, $icon);
    }

} else {
    $_SESSION['idPedido'] = $idPedido;
    $ruta = "det_pedido.php";
    $mensaje = "Máximo 50 productos por pedido";
    $icon = "warning";
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>