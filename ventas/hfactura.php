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
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<?php
$idPedido = $_POST['idPedido'];
$pedidoOperador = new PedidosOperaciones();
try {
    $pedidoOperador->updateEstadoPedido(1, $idPedido);
    $ruta = "../../../menu.php";
    $mensaje = "Pedido Habilitado para modificar correctamente";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "../../../menu.php";
    $mensaje = "Error al habilitar el Pedido";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>

