<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
if (isset($_POST['idPedido'])) {
    $idPedido = $_POST['idPedido'];
} elseif (isset($_SESSION['idPedido'])) {
    $idPedido = $_SESSION['idPedido'];
}
$pedidoOperador = new PedidosOperaciones();
$pedido = $pedidoOperador->getPedido($idPedido);
$detPedidoOperador = new DetPedidoOperaciones();
$detalle = $detPedidoOperador->getTableDetPedido($idPedido);
$invProdOperador = new InvProdTerminadosOperaciones();
$invDistOperador = new InvDistribucionOperaciones();
$validar=0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Faltante del Pedido</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor">
    <div id="saludo1"><strong>FALTANTE DE PEDIDO</strong></div>
    <div class="form-group row">
        <div class="col-1 text-right"><strong>No. de pedido</strong></div>
        <div class="col-1 bg-blue"><?= $idPedido; ?></div>
        <div class="col-1 text-right"><strong>Cliente</strong></strong></div>
        <div class="col-4 bg-blue"><?= $pedido['nomCliente'] ?></div>
        <div class="col-2 text-right"><strong>Estado</strong></div>
        <div class="col-1 bg-blue"><?= $pedido['estadoPedido'] ?></div>

    </div>
    <div class="form-group row">
        <div class="col-1 text-right"><strong>Fecha Pedido</strong></div>
        <div class="col-1 bg-blue"><?= $pedido['fechaPedido'] ?></div>
        <div class="col-2 text-right"><strong>Lugar de entrega</strong></div>
        <div class="col-4 bg-blue"><?= $pedido['nomSucursal'] ?></div>
        <div class="col-1 text-right"><strong>Vendedor</strong></div>
        <div class="col-2 bg-blue"><?= $pedido['nomPersonal'] ?></div>
    </div>
    <div class="form-group row">
        <div class="col-1 text-right"><strong>Fecha Entrega</strong></div>
        <div class="col-1 bg-blue"><?= $pedido['fechaEntrega'] ?></div>
        <div class="col-2 text-right"><strong>Dirección de entrega</strong></div>
        <div class="col-4 bg-blue"><?= $pedido['dirSucursal'] ?></div>
        <div class="col-1 text-right"><strong>Tipo de Precio</strong></div>
        <div class="col-1 bg-blue"><?= $pedido['tipoPrecio'] ?></div>
    </div>
    <div class="form-group titulo row">
        <strong>Productos faltantes del Pedido</strong>
    </div>

    <table width="624" border="0" align="center">
        <tr>
            <th width="98" align="center">Código</th>
            <th width="432" align="center">Producto</th>
            <th width="80" align="center">Cantidad</th>
        </tr>
        <?php
        for($i=0; $i<count($detalle);$i++) {
            $cod = $detalle[$i]['codProducto'];
            $cantidad = $detalle[$i]['cantProducto'];
            $producto = $detalle[$i]['producto'];
            if ($cod < 100000 && $cod>10000) {
                $invProducto = $invProdOperador->getInvTotalProdTerminado($cod);
                $invListo = $invProdOperador->getInvProdTerminadoListo($cod);
                if($invProducto<$cantidad){
                    $cantidad = $cantidad - $invProducto + $invListo;
                    echo '<tr>
							<td><div align="center">' . $cod . '</div></td>
							<td><div align="center">' . $producto . '</div></td>
							<td><div align="center">' . $cantidad . '</div></td>
							</tr>';
                    $validar++;
                }
            } elseif($cod > 100000) {
                $cod = $detalle[$i]['codProducto'];
                $cantidad = $detalle[$i]['cantProducto'];
                $producto = $detalle[$i]['producto'];
                $invProducto= $invDistOperador->getInvDistribucion($cod);
                $invListo= $invDistOperador->getInvDistribucionListo($cod);
                if($invProducto<$cantidad){
                    $cantidad = $cantidad - $invProducto + $invListo;
                    echo '<tr>
							<td><div align="center">' . $cod . '</div></td>
							<td><div align="center">' . $producto . '</div></td>
							<td><div align="center">' . $cantidad . '</div></td>
							</tr>';
                    $validar++;
                }
            }
        }
        if ($validar == 0) {
            $pedidoOperador->updateEstadoPedido('L', $idPedido);
        }
        ?>
    </table>
    <div class="form-group row">
        <div class="col-2">
            <form action="det_pedido.php" method="post">
                <input name="idPedido" type="hidden" value="<?= $idPedido; ?>"/>
                <button class="button" type="submit"><span>Volver</span></button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
	   