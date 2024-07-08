<?php
include "../../../includes/valAcc.php";
include "../../../includes/calcularDias.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if (is_array($valor)) {
        //echo $nombre_campo . print_r($valor) . '<br>';
    } else {
        //echo $nombre_campo . '=' . ${$nombre_campo} . '<br>';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Actualización de Orden de Pedido</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<?php

$fechaActual = hoy();
$diasEntrega = Calc_Dias($fechaEntrega, $fechaPedido);
$diasEntregaPedido = Calc_Dias($fechaEntrega, $fechaActual);

if (($diasEntregaPedido >= 0) && ($diasEntrega >= 0)) {
    $pedidoOperador = new PedidosOperaciones();
    $datos = array($idCliente, $fechaPedido, $fechaEntrega, $tipoPrecio, $estado, $idSucursal, $idPedido);

    try {
        $pedidoOperador->updatePedido($datos);
        $_SESSION['idPedido'] = $idPedido;
        $ruta = "det_pedido.php";
        $mensaje = "Pedido actualizado con éxito";
        $icon = "success";
    } catch (Exception $e) {
        $ruta = "buscarPedido.php";
        $mensaje = "Error al actualizar el pedido";
        $icon = "error";
    } finally {
        unset($conexion);
        unset($stmt);
        mover_pag($ruta, $mensaje, $icon);
    }
} else {
    if ($diasEntrega < 0) {
        $ruta = "buscarPedido.php";
        $mensaje = "La fecha de entrega del pedido no puede ser menor que la fecha del pedido";
        $icon = "error";
        mover_pag($ruta, $mensaje, $icon);
    }
    if ($diasEntregaPedido < 0) {
        $ruta = "buscarPedido.php";
        $mensaje = "La fecha de entrega del pedido no puede ser menor que la actual";
        $icon = "error";
        mover_pag($ruta, $mensaje, $icon);
    }
}
?>
</body>
</html>