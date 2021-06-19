<?php
include "../includes/valAcc.php";
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
$pedidoOperador = new PedidosOperaciones();
$clienteOperador = new ClientesOperaciones();
$cliente = $clienteOperador->getCliente($idCliente);
$pedidosSucursal = [];
$remisiones = [];
foreach ($pedidosList as $pedido) {
    $pedidosSucursal[] = $pedidoOperador->getSucursalClientePorPedido($pedido);
    $remisiones[]=$pedidoOperador->getRemisionPorPedido($pedido);
}
$pedido = $pedidoOperador->getPedido($pedidosList[0]);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Factura de Venta</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1"><h4>FACTURA DE VENTA</h4></div>
    <form method="post" action="make_factura.php" name="form1">
        <input type="hidden" name="idCliente" value="<?= $idCliente; ?>">
        <input type="hidden" name="idPedido" value="<?= implode(',', $pedidosList); ?>">
        <input type="hidden" name="idRemision" value="<?= implode(',', $remisiones); ?>">
        <input type="hidden" name="tipPrecio" value="<?= $pedido['idPrecio']; ?>">
        <div class="row">
            <label class="col-form-label col-2 text-start" for="idFactura"><strong>No. de Factura</strong></label>
            <label class="col-form-label col-2 text-start mx-2" for="fechaFactura"><strong>Fecha de
                    factura</strong></label>
            <label class="col-form-label col-2 text-start" for="fechaVenc"><strong>Fecha de vencimiento</strong></label>
        </div>
        <div class="form-group row">
            <input type="text" class="form-control col-2" name="idFactura" id="idFactura"
                   onkeydown="return aceptaNum(event)" required>
            <input type="date" class="form-control col-2 mx-2" name="fechaFactura" id="fechaFactura"
                   value="" required>
            <input type="date" class="form-control col-2" name="fechaVenc" id="fechaVenc" value="" required>
        </div>
        <div class="row">
            <label class="col-form-label col-6 text-start" for="nomCliente"><strong>Cliente</strong></label>
        </div>
        <div class="form-group row">
            <input type="text" class="form-control col-6" name="nomCliente" id="nomCliente"
                   value="<?= $cliente['nomCliente']; ?>" readonly>
        </div>
        <div class="row">
            <label class="col-form-label col-2 text-start" for="tipoPrecio"><strong>Tipo de precio</strong></label>
            <label class="col-form-label col-2 text-start mx-2" for="ordenCompra"><strong>Orden de
                    compra</strong></label>
            <label class="col-form-label col-2 text-start" for="descuento"><strong>Descuento</strong></label>
        </div>
        <div class="form-group row">
            <input type="text" class="form-control col-2" name="tipoPrecio" id="tipoPrecio"
                   value="<?= $pedido['tipoPrecio']; ?>" readonly>
            <input type="text" class="form-control col-2 mx-2" name="ordenCompra" id="ordenCompra"
                   onkeydown="return aceptaNum(event)" value="0" required>
            <input type="text" class="form-control col-2" name="descuento" id="descuento"
                   onkeydown="return aceptaNum(event)" value="0" required>
        </div>
        <div class="row">
            <label class="col-form-label col-6 text-start" for="nomSucursal"><strong>Pedidos</strong></label>
        </div>
        <div class="form-group row">
            <textarea name="nomSucursal" class="form-control col-6" id="nomSucursal" rows="5" readonly><?php
                foreach ($pedidosSucursal as $pedido) {
                    echo $pedido . "\n";
                }
                ?>
            </textarea>
        </div>
        <div class="row">
            <label class="col-form-label col-6 text-start" for="observaciones"><strong>Observaciones</strong></label>
        </div>
        <div class="form-group row">
            <textarea name="observaciones" class="form-control col-6" id="observaciones" rows="2"></textarea>
        </div>
        <div class="row form-group">
            <div class="col-1">
                <button class="button" type="button" onclick="return Enviar(this.form)">
                    <span>Continuar</span></button>
            </div>
        </div>
    </form>
    <div class="row form-group">
        <div class="col-1">
            <button class="button1" onclick="history.back()">
                <span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>