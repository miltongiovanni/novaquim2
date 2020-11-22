<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Creación de Orden de Pedido</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../js/validar.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/findCliente.js"></script>
    <script>
        function findSucursal(idCliente) {
            $.ajax({
                url: '../includes/controladorVentas.php',
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
<div id="contenedor">
    <div id="saludo"><strong>CREACIÓN DE ORDEN DE PEDIDO</strong></div>
    <form method="post" action="makePedido.php" name="form1">
        <div class="form-group row">
            <label class="col-form-label col-2" for="busClien"><strong>Cliente</strong></label>
            <input type="text" class="form-control col-1" id="busClien" name="busClien"
                   onkeyup="findClientePedido()"
                   required/>
            <div class="col-4" id="myDiv"></div>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2" for="idSucursal"><strong>Sucursal</strong></label>
            <div id="sucursales" class="col-5">
                <select name="idSucursal" id="idSucursal" class="form-control col-12" required>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2 text-right" for="fechaPedido"><strong>Fecha de
                    Pedido</strong></label>
            <input type="date" class="form-control col-5" name="fechaPedido" id="fechaPedido" required>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2 text-right" for="fechaEntrega"><strong>Fecha de
                    entrega</strong></label>
            <input type="date" class="form-control col-5" name="fechaEntrega" id="fechaEntrega" required>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2"><strong>Precio</strong></label>
            <div class="col-form-label col-5 ">
                <input name="tipoPrecio" type="radio" id="precio_0" value="1">
                <label for="precio_0">Fábrica</label>
                <input type="radio" name="tipoPrecio" value="2" id="precio_1" checked>
                <label for="precio_1">Distribuidor</label>
                <input type="radio" name="tipoPrecio" value="3" id="precio_2">
                <label for="precio_2">Detal</label>
                <input type="radio" name="tipoPrecio" value="4" id="precio_3">
                <label for="precio_3">Mayorista</label>
                <input type="radio" name="tipoPrecio" value="5" id="precio_4">
                <label for="precio_4">Superetes</label>
            </div>
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