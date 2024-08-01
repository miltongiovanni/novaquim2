<?php
include "../../../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Creación de Orden de Pedido</title>
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
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>CREACIÓN DE ORDEN DE PEDIDO</h4></div>
    <form method="post" action="makePedido.php" name="form1">
        <div class="mb-3 row">
            <div class="col-4">
                <label class="form-label" for="busClien"><strong>Cliente: </strong></label>
                <input type="text" class="form-control" id="busClien" name="busClien" onkeyup="findClientePedido()" required/>
            </div>
        </div>
        <div class="row">
            <div class="col-4" id="myDiv"></div>
        </div>
        <div class="mb-3 row">
            <div class="col-4">
                <label class="form-label" for="idSucursal"><strong>Sucursal: </strong></label>
                <div id="sucursales" class="w-100">
                    <select name="idSucursal" id="idSucursal" class="form-select" required>
                    </select>
                </div>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-2">
                <label class="form-label" for="fechaPedido"><strong>Fecha de Pedido: </strong></label>
                <input type="date" class="form-control" name="fechaPedido" id="fechaPedido" required>
            </div>
            <div class="col-2">
                <label class="form-label" for="fechaEntrega"><strong>Fecha de entrega: </strong></label>
                <input type="date" class="form-control" name="fechaEntrega" id="fechaEntrega" required>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-4">
                <label class="form-label"><strong>Precio: </strong></label>
                <div class=" ">
                    <input name="tipoPrecio" type="radio" id="precio_0" value="1">
                    <label class="pe-2" for="precio_0">Fábrica</label>
                    <input type="radio" name="tipoPrecio" value="2" id="precio_1" checked>
                    <label class="pe-2" for="precio_1">Distribuidor</label>
                    <input type="radio" name="tipoPrecio" value="3" id="precio_2">
                    <label class="pe-2" for="precio_2">Detal</label>
                    <input type="radio" name="tipoPrecio" value="4" id="precio_3">
                    <label class="pe-2" for="precio_3">Mayorista</label>
                    <input type="radio" name="tipoPrecio" value="5" id="precio_4">
                    <label class="pe-2" for="precio_4">Superetes</label>
                </div>
            </div>

        </div>
        <div class="row mb-3">
            <div class="col-1">
                <button class="button" type="button" onclick="return Enviar(this.form)">
                    <span>Continuar</span>
                </button>
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