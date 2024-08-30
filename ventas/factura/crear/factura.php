<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Factura de Venta</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>FACTURA DE VENTA</h4></div>
    <?php
    $pedidoOperador = new PedidosOperaciones();
    $clienteOperador = new ClientesOperaciones();
    $cliente = $clienteOperador->getCliente($idCliente);
    $pedidosSucursal = [];
    $remisiones = [];
    if (isset($pedidosList)){
        foreach ($pedidosList as $pedido) {
            $pedidosSucursal[] = $pedidoOperador->getSucursalClientePorPedido($pedido);
            $remisiones[] = $pedidoOperador->getRemisionPorPedido($pedido);
        }
        $pedido = $pedidoOperador->getPedido($pedidosList[0]);
    }else{
        $ruta = "../crear/";
        $mensaje = "Debe seleccionar al menos un pedido, intente de nuevo";
        $icon = "warning";
        mover_pag($ruta, $mensaje, $icon);
        exit;
    }
    ?>
    <form method="post" action="make_factura.php" name="form1">
        <input type="hidden" name="idCliente" value="<?= $idCliente; ?>">
        <input type="hidden" name="idPedido" value="<?= implode(',', $pedidosList); ?>">
        <input type="hidden" name="tipPrecio" value="<?= $pedido['idPrecio']; ?>">
        <div class="row mb-3">
            <div class="col-2">
                <label class="form-label" for="idFactura"><strong>No. de Factura</strong></label>
                <input type="text" class="form-control" name="idFactura" id="idFactura"
                       onkeydown="return aceptaNum(event)" required>
            </div>
            <div class="col-2">
                <label class="form-label" for="fechaFactura"><strong>Fecha de factura</strong></label>
                <input type="date" class="form-control" name="fechaFactura" id="fechaFactura"
                       value="" required>
            </div>
            <div class="col-2">
                <label class="form-label" for="fechaVenc"><strong>Fecha de vencimiento</strong></label>
                <input type="date" class="form-control" name="fechaVenc" id="fechaVenc" value="" required>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-6">
                <label class="form-label" for="nomCliente"><strong>Cliente</strong></label>
                <input type="text" class="form-control" name="nomCliente" id="nomCliente"
                       value="<?= $cliente['nomCliente']; ?>" readonly>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-2">
                <label class="form-label" for="tipoPrecio"><strong>Tipo de precio</strong></label>
                <input type="text" class="form-control" name="tipoPrecio" id="tipoPrecio"
                       value="<?= $pedido['tipoPrecio']; ?>" readonly>
            </div>
            <div class="col-2">
                <label class="form-label" for="ordenCompra"><strong>Orden de compra</strong></label>
                <input type="text" class="form-control" name="ordenCompra" id="ordenCompra"
                       onkeydown="return aceptaNum(event)" value="0" required>
            </div>
            <div class="col-2">
                <label class="form-label" for="descuento"><strong>Descuento</strong></label>
                <input type="text" class="form-control" name="descuento" id="descuento"
                       onkeydown="return aceptaNum(event)" value="0" required>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-6">
                <label class="form-label" for="nomSucursal"><strong>Pedidos</strong></label>
                <textarea name="nomSucursal" class="form-control" id="nomSucursal" rows="5" readonly><?php
                    foreach ($pedidosSucursal as $pedido) {
                        echo $pedido . "\n";
                    }
                    ?>
            </textarea>
            </div>
        </div>
        <div class="row">

        </div>
        <div class="mb-3 row">
            <div class="col-6">
                <label class="form-label" for="observaciones"><strong>Observaciones</strong></label>
                <textarea name="observaciones" class="form-control" id="observaciones" rows="2"></textarea>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-1">
                <button class="button" type="button" onclick="return Enviar(this.form)">
                    <span>Continuar</span></button>
            </div>
        </div>
    </form>
    <div class="row mb-3">
        <div class="col-1">
            <button class="button1" onclick="history.back()">
                <span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>