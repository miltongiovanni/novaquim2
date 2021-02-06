<?php
include "../includes/valAcc.php";
include "../includes/calcularDias.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
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
    } catch (Exception $e) {
        $ruta = "buscarPedido.php";
        $mensaje = "Error al actualizar el pedido";
    } finally {
        unset($conexion);
        unset($stmt);
        mover_pag($ruta, $mensaje, $icon);
    }
} else {
    if ($diasEntrega < 0) {
        echo '<script >
				alert("La fecha de entrega del pedido no puede ser menor que la fecha del pedido");
				self.location="buscarPedido.php";
				</script>';
    }
    if ($diasEntregaPedido < 0) {
        echo '<script >
				alert("La fecha de entrega del pedido no puede ser menor que la actual");
				self.location="buscarPedido.php";
				</script>';
    }
}

