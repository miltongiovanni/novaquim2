<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
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
$validar = 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Faltante del Pedido</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <style>
        .width1 {
            width: 15%;
        }

        .width2 {
            width: 70%;
        }

        .width3 {
            width: 15%;
        }
    </style>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>FALTANTE DE PEDIDO</h4></div>
    <div class="form-group row">
        <div class="col-1 text-end"><strong>No. de pedido</strong></div>
        <div class="col-1 bg-blue"><?= $idPedido; ?></div>
        <div class="col-1 text-end"><strong>Cliente</strong></strong></div>
        <div class="col-4 bg-blue"><?= $pedido['nomCliente'] ?></div>
        <div class="col-2 text-end"><strong>Estado</strong></div>
        <div class="col-1 bg-blue"><?= $pedido['estadoPedido'] ?></div>

    </div>
    <div class="form-group row">
        <div class="col-1 text-end"><strong>Fecha Pedido</strong></div>
        <div class="col-1 bg-blue"><?= $pedido['fechaPedido'] ?></div>
        <div class="col-2 text-end"><strong>Lugar de entrega</strong></div>
        <div class="col-4 bg-blue"><?= $pedido['nomSucursal'] ?></div>
        <div class="col-1 text-end"><strong>Vendedor</strong></div>
        <div class="col-2 bg-blue"><?= $pedido['nomPersonal'] ?></div>
    </div>
    <div class="form-group row">
        <div class="col-1 text-end"><strong>Fecha Entrega</strong></div>
        <div class="col-1 bg-blue"><?= $pedido['fechaEntrega'] ?></div>
        <div class="col-2 text-end"><strong>Dirección de entrega</strong></div>
        <div class="col-4 bg-blue"><?= $pedido['dirSucursal'] ?></div>
        <div class="col-1 text-end"><strong>Precio</strong></div>
        <div class="col-1 bg-blue"><?= $pedido['tipoPrecio'] ?></div>
    </div>
    <div class="form-group titulo row text-center">
        <strong>Productos faltantes del Pedido</strong>
    </div>
    <div class="tabla-50">
        <table>
            <tr>
                <th class="text-center width1">Código</th>
                <th class="text-center width2">Producto</th>
                <th class="text-center width3">Cantidad</th>
            </tr>
            <?php
            for ($i = 0; $i < count($detalle); $i++) {
                $cod = $detalle[$i]['codProducto'];
                $cantidad = $detalle[$i]['cantProducto'];
                $producto = $detalle[$i]['producto'];
                if ($cod < 100000 && $cod > 10000) {
                    $invProducto = $invProdOperador->getInvTotalProdTerminado($cod);
                    $invListo = $invProdOperador->getInvProdTerminadoListo($cod);
                    if ($invProducto < $cantidad) {
                        $cantidad = $cantidad - $invProducto + $invListo;
                        echo '<tr>
							<td><div class="text-center">' . $cod . '</div></td>
							<td><div class="text-start">' . $producto . '</div></td>
							<td><div class="text-center">' . $cantidad . '</div></td>
							</tr>';
                        $validar++;
                    }
                } elseif ($cod > 100000) {
                    $cod = $detalle[$i]['codProducto'];
                    $cantidad = $detalle[$i]['cantProducto'];
                    $producto = $detalle[$i]['producto'];
                    $invProducto = $invDistOperador->getInvDistribucion($cod);
                    $invListo = $invDistOperador->getInvDistribucionListo($cod);
                    if ($invProducto < $cantidad) {
                        $cantidad = $cantidad - $invProducto + $invListo;
                        echo '<tr>
							<td><div class="text-center">' . $cod . '</div></td>
							<td><div class="text-center">' . $producto . '</div></td>
							<td><div class="text-center">' . $cantidad . '</div></td>
							</tr>';
                        $validar++;
                    }
                }
            }
            if ($validar == 0) {
                $pedidoOperador->updateEstadoPedido(2, $idPedido);
            }
            ?>
        </table>
    </div>
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
	   