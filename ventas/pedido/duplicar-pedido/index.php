<?php
include "../../../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idPedido = $_POST['idPedido'];
$pedidoOperador = new PedidosOperaciones();
$detPedidoOperador = new DetPedidoOperaciones();
$pedido = $pedidoOperador->getPedido($idPedido);
$detPedido = $detPedidoOperador->getDetPedido($idPedido);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Duplicar Pedido</title>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25">
        <h4>DUPLICAR PEDIDO</h4>
    </div>

    <div class="mb-3 row formatoDatos5">

        <div class="col-4">
            <strong>Cliente</strong>
            <div class="bg-blue"><?= $pedido['nomCliente'] ?></div>
        </div>
        <div class="col-1">
            <strong>Precio</strong>
            <div class="bg-blue"><?= $pedido['tipoPrecio'] ?></div>
        </div>
        <div class="col-3">
            <strong>Lugar de entrega</strong>
            <div class="bg-blue"><?= $pedido['nomSucursal'] ?></div>
        </div>
        <div class="col-3">
            <strong>Dirección de entrega</strong>
            <div class="bg-blue"><?= $pedido['dirSucursal'] ?></div>
        </div>

    </div>

    <div class="mb-3 titulo row text-center">
        <strong>Detalle del pedido</strong>
    </div>
    <div class="tabla-50">
        <table id="example" class="formatoDatos5 table table-sm table-striped">
            <thead>
            <tr>
                <th class="text-center">Item</th>
                <th class="text-center">Código</th>
                <th class="text-center">Producto</th>
                <th class="text-center">Cantidad</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($detPedido as $key => $detalle) :
            ?>
            <tr>
                <td class="text-center"><?=($key+1)?></td>
                <td class="text-center"><?=($detalle['codProducto'])?></td>
                <td><?=($detalle['Producto'])?></td>
                <td class="text-center"><?=($detalle['cantProducto'])?></td>
            </tr>
            <?php
            endforeach;
            ?>
            </tbody>
        </table>
    </div>

    <div class="row">
        <div class="col-2">
            <form method="post" action="duplicarPedido.php" name="form3">
                <input name="idPedido" type="hidden" value="<?= $idPedido; ?>">
                <button class="button" type="button" onclick="return Enviar(this.form)"><span>Duplicar pedido</span></button>
            </form>
        </div>
        <div class="col-1">
            <button class="button1" id="back" onclick="window.location='../consulta-cliente/'"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>
