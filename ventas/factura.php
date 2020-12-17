<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idPedido = $_POST['idPedido'];
$pedidoOperador = new PedidosOperaciones();
$pedido = $pedidoOperador->getPedido($idPedido);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Factura de Venta</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script  src="../js/validar.js"></script>
</head>
<body> 	
<div id="contenedor">
<div id="saludo1"><strong>FACTURA DE VENTA</strong></div>
    <form method="post" action="make_factura.php" name="form1">
        <input type="hidden" name="idCliente" value="<?=$pedido['idCliente'];?>">
        <input type="hidden" name="idPedido" value="<?=$idPedido;?>">
        <input type="hidden" name="idSucursal" value="<?=$pedido['idSucursal'];?>">
        <input type="hidden" name="tipPrecio" value="<?=$pedido['idPrecio'];?>">
        <div class="row">
            <label class="col-form-label col-2 text-left"  for="idFactura"><strong>No. de Factura</strong></label>
            <label class="col-form-label col-2 text-left mx-2"  for="fechaFactura"><strong>Fecha de factura</strong></label>
            <label class="col-form-label col-2 text-left"  for="fechaVenc"><strong>Fecha de vencimiento</strong></label>
        </div>
        <div class="form-group row">
            <input type="text" class="form-control col-2" name="idFactura" id="idFactura" onKeyPress="return aceptaNum(event)" required>
            <input type="date" class="form-control col-2 mx-2" name="fechaFactura" id="fechaFactura" value="<?=$pedido['fechaEntrega'];?>" required>
            <input type="date" class="form-control col-2" name="fechaVenc" id="fechaVenc" value="" required>
        </div>
        <div class="row">
            <label class="col-form-label col-4 text-left mr-2"  for="nomCliente"><strong>Cliente</strong></label>
            <label class="col-form-label col-2 text-left ml-2"  for="tipoPrecio"><strong>Tipo de precio</strong></label>
        </div>
        <div class="form-group row">
            <input type="text" class="form-control col-4 mr-2" name="nomCliente" id="nomCliente" value="<?=$pedido['nomCliente'];?>" readonly>
            <input type="text" class="form-control col-2 ml-2" name="tipoPrecio" id="tipoPrecio" value="<?=$pedido['tipoPrecio'];?>" readonly>
        </div>
        <div class="row">
            <label class="col-form-label col-4 text-left mr-2"  for="nomSucursal"><strong>Lugar de entrega</strong></label>
            <label class="col-form-label col-2 text-left ml-2"  for="ordenCompra"><strong>Orden de compra</strong></label>
        </div>
        <div class="form-group row">
            <input type="text" class="form-control col-4 mr-2" name="nomSucursal" id="nomSucursal" value="<?=$pedido['nomSucursal'];?>" readonly>
            <input type="text" class="form-control col-2 ml-2" name="ordenCompra" id="ordenCompra" onKeyPress="return aceptaNum(event)" value="0" required>
        </div>
        <div class="row">
            <label class="col-form-label col-4 text-left mr-2"  for="dirSucursal"><strong>Dirección de entrega</strong></label>
            <label class="col-form-label col-2 text-left ml-2"  for="descuento"><strong>Descuento</strong></label>
        </div>
        <div class="form-group row">
            <input type="text" class="form-control col-4 mr-2" name="dirSucursal" id="dirSucursal" value="<?=$pedido['dirSucursal'];?>" readonly>
            <input type="text" class="form-control col-2 ml-2" name="descuento" id="descuento" onKeyPress="return aceptaNum(event)" value="0" required>
        </div>
        <div class="row">
            <label class="col-form-label col-6 text-left"  for="observaciones"><strong>Observaciones</strong></label>
        </div>
        <div class="form-group row">
            <textarea name="observaciones" class="form-control col-6" id="observaciones" rows="2"></textarea>
        </div>
        <div class="row form-group">
            <div class="col-1">
                <button class="button" onclick="return Enviar(this.form)">
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