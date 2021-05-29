<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Crear Factura a partir del Pedido</title>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link href="../node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../node_modules/select2/dist/js/select2.min.js"></script>
    <script src="../node_modules/select2/dist/js/i18n/es.js"></script>
    <script src="../js/findCliente.js"></script>
    <script>
        function findPedidosPorFacturar(idCliente) {
            $.ajax({
                url: '../includes/controladorVentas.php',
                type: 'POST',
                data: {
                    "action": 'findPedidosPorFacturar',
                    "idCliente": idCliente
                },
                dataType: 'html',
                success: function (pedidos) {
                    $("#pedidosList").html(pedidos);
                },
                error: function () {
                    alert("Vous avez un GROS problème");
                }
            });
        }
        $(document).ready(function() {
            $('.js-multiple').select2({
                language: "es"
            });
        });
    </script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo"><h4>CREAR FACTURA A PARTIR DEL PEDIDO</h4></div>
    <form id="form1" name="form1" method="post" action="factura.php">
        <div class="form-group row">
            <label class="col-form-label col-2" for="busClien"><strong>Cliente</strong></label>
            <input type="text" class="form-control col-1 ms-2" id="busClien" name="busClien"
                   onkeyup="findClienteParaFacturar()"
                   required/>
            <div class="col-4" id="myDiv"></div>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2" for="pedidosList"><strong>Pedidos</strong></label>
            <div id="pedidos" class="col-5">
                <select name="pedidosList[]" multiple="multiple" id="pedidosList" class="form-control col-12 js-multiple" required>
                </select>
            </div>
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
            <button class="button1" onclick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>
