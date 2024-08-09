<?php
include "../../../includes/valAcc.php";
include "../../../includes/calcularDias.php";
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
    <title>Entrega de Pedidos</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<?php
$ruteroOperador = new RuteroOperaciones();
$pedidoOperador = new PedidosOperaciones();

if (isset($_POST['seleccion1'])) {
    $selPedidos = $_POST['seleccion1'];
    try {
        foreach ($selPedidos as $pedido) {
            $pedidoOperador->updateEstadoPedido(7, $pedido);
        }
        $ruta = "../entrega-pedidos/";
        $mensaje = "Pedidos entregados con éxito";
        $icon = "success";
    } catch (Exception $e) {
        $ruta = "../entrega-pedidos/";
        $mensaje = "Error al entregar los pedidos";
        $icon = "error";
    } finally {
        unset($conexion);
        unset($stmt);
        mover_pag($ruta, $mensaje, $icon);
    }
} else {
    $ruta = "../entrega-pedidos/";
    $mensaje = "Debe escoger algún pedido";
    $icon = "warning";
    mover_pag($ruta, $mensaje, $icon);
}


?>

</body>
</html>
