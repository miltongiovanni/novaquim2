<?php
include "../../../includes/valAcc.php";
$idPedido = $_POST['idPedido'];
$codProducto = $_POST['codProducto'];

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$DetPedidoOperador = new DetPedidoOperaciones();
$detalle = $DetPedidoOperador->getDetProdPedido($idPedido, $codProducto);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar datos del Pedido</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>

</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>ACTUALIZACIÓN DEL PRODUCTO EN EL PEDIDO</h4></div>
    <form action="updatePed.php" method="post" name="actualiza">
        <input name="idPedido" type="hidden" value="<?= $idPedido; ?>">
        <input name="codProducto" type="hidden" value="<?= $codProducto; ?>">
        <div class="row mb-3">
            <div class="col-4">
                <label class="form-label" for="producto"><strong>Producto</strong></label>
                <input type="text" class="form-control" name="producto" readonly id="producto" value="<?= $detalle['producto'] ?>">
            </div>
            <div class="col-1">
                <label class="form-label" for="cantProducto"><strong>Cantidad</strong></label>
                <input type="text" class="form-control" name="cantProducto" id="cantProducto" onkeydown="return aceptaNum(event)" value="<?= $detalle['cantProducto'] ?>">
            </div>
            <div class="col-1">
                <label class="form-label" for="precioProducto"><strong>Precio</strong></label>
                <input type="text" class="form-control" name="precioProducto" id="precioProducto" onkeydown="return aceptaNum(event)" value="<?= $detalle['precioProducto'] ?>">
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-2 text-center">
                <button class="button" type="button" onclick="return Enviar(this.form)"><span>Actualizar detalle</span>
                </button>
            </div>
        </div>
    </form>
</div>
</body>
</html>
