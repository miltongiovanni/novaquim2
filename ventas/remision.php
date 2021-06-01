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
    <title>Salida por remisión</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1"><h4>SALIDA POR REMISIÓN</h4></div>
    <form method="post" action="make_remision.php" name="form1">
        <input type="hidden" name="idCliente" value="<?= $pedido['idCliente']; ?>">
        <input type="hidden" name="idPedido" value="<?= $idPedido; ?>">
        <input type="hidden" name="idSucursal" value="<?= $pedido['idSucursal']; ?>">
        <div class="row">
            <label class="col-form-label col-4 text-start" for="fechaRemision"><strong>Fecha de
                    remisión</strong></label>
        </div>
        <div class="form-group row">
            <input type="date" class="form-control col-4" name="fechaRemision" id="fechaRemision"
                   value="<?= $pedido['fechaEntrega']; ?>" required>
        </div>
        <div class="row">
            <label class="col-form-label col-4 text-start" for="nomCliente"><strong>Cliente</strong></label>
        </div>
        <div class="form-group row">
            <input type="text" class="form-control col-4" name="nomCliente" id="nomCliente"
                   value="<?= $pedido['nomCliente']; ?>" readonly>
        </div>
        <div class="row">
            <label class="col-form-label col-4 text-start" for="nomSucursal"><strong>Lugar de
                    entrega</strong></label>
        </div>
        <div class="form-group row">
            <input type="text" class="form-control col-4" name="nomSucursal" id="nomSucursal"
                   value="<?= $pedido['nomSucursal']; ?>" readonly>
        </div>
        <div class="row">
            <label class="col-form-label col-4 text-start" for="dirSucursal"><strong>Dirección de
                    entrega</strong></label>
        </div>
        <div class="form-group row">
            <input type="text" class="form-control col-4" name="dirSucursal" id="dirSucursal"
                   value="<?= $pedido['dirSucursal']; ?>" readonly>
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