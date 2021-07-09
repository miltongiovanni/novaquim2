<?php
include "../includes/valAcc.php";
$idPedido = $_POST['idPedido'];
$codProducto = $_POST['codProducto'];

function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$DetPedidoOperador = new DetPedidoOperaciones();
$detalle = $DetPedidoOperador->getDetProdPedido($idPedido, $codProducto);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar datos del Pedido</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>

</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2"><h4>ACTUALIZACIÓN DEL PRODUCTO EN EL PEDIDO</h4></div>
    <form action="updatePed.php" method="post" name="actualiza">
        <input name="idPedido" type="hidden" value="<?= $idPedido; ?>">
        <input name="codProducto" type="hidden" value="<?= $codProducto; ?>">
        <div class="row">
            <label class="col-form-label col-4 text-center mx-2" for="producto"><strong>Producto</strong></label>
            <label class="col-form-label col-1 text-center mx-2" for="cantProducto"><strong>Cantidad</strong></label>
            <label class="col-form-label col-1 text-center mx-2" for="precioProducto"><strong>Precio</strong></label>
        </div>
        <div class="form-group row">
            <input type="text" class="form-control col-4 mx-2" name="producto" readonly
                   id="producto" value="<?= $detalle['producto'] ?>">
            <input type="text" class="form-control col-1 mx-2" name="cantProducto"
                   id="cantProducto" onkeydown="return aceptaNum(event)" value="<?= $detalle['cantProducto'] ?>">
            <input type="text" class="form-control col-1 mx-2" name="precioProducto" id="precioProducto"
                   onkeydown="return aceptaNum(event)" value="<?= $detalle['precioProducto'] ?>">
        </div>
        <div class="form-group row">
            <div class="col-2 text-center" style="padding: 0 20px;">
                <button class="button" type="button" onclick="return Enviar(this.form)"><span>Actualizar detalle</span>
                </button>
            </div>
        </div>
    </form>
</div>
</body>
</html>
