<?php
include "../includes/valAcc.php";
// Función para cargar las clases
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
if (isset($_POST['idFactura'])) {
    $idFactura = $_POST['idFactura'];
} elseif (isset($_SESSION['idFactura'])) {
    $idFactura = $_SESSION['idFactura'];
}
$facturaOperador = new FacturasOperaciones();
$factura = $facturaOperador->getFactura($idFactura);
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
    <div id="saludo1">
        <img src="../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>FACTURA DE VENTA</h4></div>
    <form method="post" action="updateFactura.php" name="form1">
        <input type="hidden" name="idPedido" id="idPedido" value="<?= $factura['idPedido'] ?>">
        <div class="form-group row">
            <label class="col-form-label col-2 text-end" for="idFactura"><strong>No. de Factura</strong></label>
            <input type="text" class="form-control col-5" name="idFactura" value="<?= $factura['idFactura'] ?>"
                   id="idFactura" readonly required>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2 text-end" for="nomCliente"><strong>Cliente</strong></label>
            <input type="hidden" name="idCliente" id="idCliente" value="<?= $factura['idCliente'] ?>">
            <input type="text" class="form-control col-5" name="nomCliente" value="<?= $factura['nomCliente'] ?>"
                   id="nomCliente" readonly>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2 text-end" for="fechaFactura"><strong>Fecha de Venta</strong></label>
            <input type="date" class="form-control col-5" name="fechaFactura" value="<?= $factura['fechaFactura'] ?>"
                   id="fechaFactura" required>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2 text-end" for="fechaVenc"><strong>Fecha de Vencimiento</strong></label>
            <input type="date" class="form-control col-5" name="fechaVenc" value="<?= $factura['fechaVenc'] ?>"
                   id="fechaVenc" required>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2 text-end" for="vendedor"><strong>Vendedor</strong></label>
            <input type="hidden" name="idPersonal" id="idPersonal" value="<?= $factura['idPersonal'] ?>">
            <input type="text" class="form-control col-5" name="vendedor" value="<?= $factura['vendedor'] ?>"
                   id="vendedor" readonly>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2"><strong>Precio</strong></label>
            <div class="col-form-label col-5 ">
                <input name="tipPrecio" type="radio" id="precio_0"
                       value="1" <?= $factura['tipPrecio'] == 1 ? 'checked' : '' ?>>
                <label for="precio_0">Fábrica</label>
                <input type="radio" name="tipPrecio" value="2"
                       id="precio_1" <?= $factura['tipPrecio'] == 2 ? 'checked' : '' ?>>
                <label for="precio_1">Distribuidor</label>
                <input type="radio" name="tipPrecio" value="3"
                       id="precio_2" <?= $factura['tipPrecio'] == 3 ? 'checked' : '' ?>>
                <label for="precio_2">Detal</label>
                <input type="radio" name="tipPrecio" value="4"
                       id="precio_3" <?= $factura['tipPrecio'] == 4 ? 'checked' : '' ?>>
                <label for="precio_3">Mayorista</label>
                <input type="radio" name="tipPrecio" value="5"
                       id="precio_4" <?= $factura['tipPrecio'] == 5 ? 'checked' : '' ?>>
                <label for="precio_4">Superetes</label>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2 text-end" for="ordenCompra"><strong>Orden de Compra</strong></label>
            <input type="text" class="form-control col-5" onkeydown="return aceptaNum(event)" name="ordenCompra"
                   value="<?= $factura['ordenCompra'] ?>" id="ordenCompra">
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2 text-end" for="descuento"><strong>Descuento</strong></label>
            <input type="text" class="form-control col-5" onkeydown="return aceptaNum(event)" name="descuento"
                   value="<?= $factura['descuento'] * 100 ?>" id="descuento">
        </div>
        <div class="form-group row">
            <label class="col-2 text-end col-form-label" for="observaciones"><strong>Observaciones</strong></label>
            <textarea class="form-control col-5" name="observaciones"><?= $factura['observaciones'] ?></textarea>
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