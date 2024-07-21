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
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
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
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>FALTANTE DE PEDIDO</h4></div>
    <div class="mb-3 row formatoDatos5">
        <div class="col-1">
            <strong>No. de pedido</strong>
            <div class="bg-blue"><?= $idPedido; ?></div>
        </div>
        <div class="col-1">
            <strong>Fecha Pedido</strong>
            <div class="bg-blue"><?= $pedido['fechaPedido'] ?></div>
        </div>
        <div class="col-1">
            <strong>Fecha Entrega</strong>
            <div class="bg-blue"><?= $pedido['fechaEntrega'] ?></div>
        </div>
        <div class="col-4">
            <strong>Cliente</strong>
            <div class="bg-blue"><?= $pedido['nomCliente'] ?></div>
        </div>
        <div class="col-2">
            <strong>Estado</strong>
            <div class="bg-blue"><?= $pedido['estadoPedido'] ?></div>
        </div>

    </div>
    <div class="mb-3 row formatoDatos5">
        <div class="col-3">
            <strong>Lugar de entrega</strong>
            <div class="bg-blue"><?= $pedido['nomSucursal'] ?></div>
        </div>
        <div class="col-3">
            <strong>Dirección de entrega</strong>
            <div class="bg-blue"><?= $pedido['dirSucursal'] ?></div>
        </div>
        <div class="col-1">
            <strong>Precio</strong>
            <div class="bg-blue"><?= $pedido['tipoPrecio'] ?></div>
        </div>
        <div class="col-2">
            <strong>Vendedor</strong>
            <div class="bg-blue"><?= $pedido['nomPersonal'] ?></div>
        </div>
    </div>
    <div class="mb-3 titulo row text-center">
        <strong>Productos faltantes del Pedido</strong>
    </div>
    <div class="tabla-50">
        <table class="formatoDatos5 table table-sm table-striped">
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
    <div class="mb-3 row">
        <div class="col-2">
            <form action="index.php" method="post">
                <input name="idPedido" type="hidden" value="<?= $idPedido; ?>"/>
                <button class="button" type="submit"><span>Volver</span></button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
	   