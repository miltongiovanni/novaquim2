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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Creación de Orden de Pedido</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<?php
$fechaActual = hoy();
$diasPedido = Calc_Dias($fechaPedido, $fechaActual);
$diasEntrega = Calc_Dias($fechaEntrega, $fechaPedido);
$diasEntregaPedido = Calc_Dias($fechaEntrega, $fechaActual);
$idUsuario = $_SESSION['IdUsuario'];

if (($diasPedido >= 0) && ($diasEntregaPedido >= 0) && ($diasEntrega >= 0)) {
    $pedidoOperador = new PedidosOperaciones();
    $estado = 'P';
    $datos = array($idCliente, $fechaPedido, $fechaEntrega, $tipoPrecio, $estado, $idSucursal, $idUsuario);

    try {
        $lastIdPedido = $pedidoOperador->makePedido($datos);
        $_SESSION['idPedido'] = $lastIdPedido;
        $ruta = "det_pedido.php";
        $mensaje = "Pedido creado con éxito";
        $icon = "success";
    } catch (Exception $e) {
        $ruta = "pedido.php";
        $mensaje = "Error al crear el pedido";
        $icon = "error";
    } finally {
        unset($conexion);
        unset($stmt);
        mover_pag($ruta, $mensaje, $icon);
    }
} else {
    if ($diasPedido < 0) {
        echo '<script >
				alert("La fecha del pedido no puede ser menor que la actual");
				self.location="pedido.php";
				</script>';
    }
    if ($diasEntrega < 0) {
        echo '<script >
				alert("La fecha de entrega del pedido no puede ser menor que la fecha del pedido");
				self.location="pedido.php";
				</script>';
    }
    if ($diasEntregaPedido < 0) {
        echo '<script >
				alert("La fecha de entrega del pedido no puede ser menor que la actual");
				self.location="pedido.php";
				</script>';
    }
}
?>
</body>
</html>
