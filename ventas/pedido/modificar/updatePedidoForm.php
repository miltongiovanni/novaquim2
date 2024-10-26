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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Actualización de Orden de Pedido</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/findCliente.js"></script>
    <script>
        function findSucursal(idCliente) {
            $.ajax({
                url: '../../../includes/controladorVentas.php',
                type: 'POST',
                data: {
                    "action": 'findSucursalesByCliente',
                    "idCliente": idCliente
                },
                dataType: 'html',
                success: function (sucursalesList) {
                    $("#idSucursal").html(sucursalesList);
                },
                error: function () {
                    alert("Vous avez un GROS problème");
                }
            });
        }
    </script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>ACTUALIZACIÓN DE ORDEN DE PEDIDO</h4></div>
    <form method="post" action="updatePedido.php" name="form1">
        <div class="mb-3 row">
            <div class="col-2">
                <label class="form-label" for="idPedido"><strong>Pedido</strong></label>
                <input type="text" class="form-control" name="idPedido" value="<?= $pedido['idPedido'] ?>" id="idPedido" readonly required>
            </div>
            <div class="col-2">
                <label class="form-label" for="estadoPedido"><strong>Estado</strong></label>
                <input type="hidden" name="estado" id="estado" value="<?= $pedido['estado'] ?>">
                <input type="text" class="form-control" name="estadoPedido" value="<?= $pedido['estadoPedido'] ?>" id="estadoPedido" readonly>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-4">
                <label class="form-label col-2" for="busClien"><strong>Cliente</strong></label>
                <input type="text" class="form-control col-1" id="busClien" name="busClien" onkeyup="findClientePedido()"/>
            </div>
        </div>
        <div class="row">
            <div class="col-4" id="myDiv">
                <input type="hidden" name="idCliente" id="idCliente" value="<?= $pedido['idCliente'] ?>">
                <input type="text" name="nomCliente" id="nomCliente" class="form-control mb-3"
                       value="<?= $pedido['nomCliente'] ?>" readOnly>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-4">
                <label class="form-label" for="idSucursal"><strong>Sucursal</strong></label>
                <div id="sucursales" class="">
                    <select name="idSucursal" id="idSucursal" class="form-select" required>
                        <option value='<?= $pedido['idSucursal'] ?>'><?= $pedido['nomSucursal'] ?></option>
                    </select>
                </div>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-2">
                <label class="form-label" for="fechaPedido"><strong>Fecha de Pedido</strong></label>
                <input type="date" class="form-control" name="fechaPedido" value="<?= $pedido['fechaPedido'] ?>" id="fechaPedido" required>
            </div>
            <div class="col-2">
                <label class="form-label" for="fechaEntrega"><strong>Fecha de entrega</strong></label>
                <input type="date" class="form-control" name="fechaEntrega" value="<?= $pedido['fechaEntrega'] ?>" id="fechaEntrega" required>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-4">
                <label class="form-label"><strong>Precio</strong></label>
                <div class="">
                    <input name="tipoPrecio" type="radio" id="precio_0" value="1" <?= $pedido['idPrecio'] == 1 ? 'checked' : '' ?>>
                    <label class="pe-2" for="precio_0">Fábrica</label>
                    <input type="radio" name="tipoPrecio" value="2" id="precio_1" <?= $pedido['idPrecio'] == 2 ? 'checked' : '' ?>>
                    <label class="pe-2" for="precio_1">Distribuidor</label>
                    <input type="radio" name="tipoPrecio" value="3" id="precio_2" <?= $pedido['idPrecio'] == 3 ? 'checked' : '' ?>>
                    <label class="pe-2" for="precio_2">Detal</label>
                    <input type="radio" name="tipoPrecio" value="4" id="precio_3" <?= $pedido['idPrecio'] == 4 ? 'checked' : '' ?>>
                    <label class="pe-2" for="precio_3">Mayorista</label>
                    <input type="radio" name="tipoPrecio" value="5" id="precio_4" <?= $pedido['idPrecio'] == 5 ? 'checked' : '' ?>>
                    <label class="pe-2" for="precio_4">Superetes</label>
                </div>
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