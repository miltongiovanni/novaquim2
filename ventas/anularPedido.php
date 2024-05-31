<?php
include "../../../includes/valAcc.php";
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
    <title>Seleccionar Orden de Pedido a Anular</title>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<?php
$idPedido = $_POST['idPedido'];
$pedidoOperador = new PedidosOperaciones();
$detPedidoOperador = new DetPedidoOperaciones();
try {
    $pedidoOperador->updateEstadoPedido(6, $idPedido);
    $detPedidoOperador->deleteAllDetPedido($idPedido);
    $ruta = "listarPedidoA.php";
    $mensaje = "Orden de pedido anulada con éxito";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "../menu.php";
    $mensaje = "Error al anular la orden de pedido";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>
