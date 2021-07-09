<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Crear Nota Crédito</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/findCliente.js"></script>
    <script>
        function findFacturasCliente(idCliente) {
            $.ajax({
                url: '../includes/controladorVentas.php',
                type: 'POST',
                data: {
                    "action": 'findFacturasByCliente',
                    "idCliente": idCliente
                },
                dataType: 'html',
                success: function (facturasList) {
                    $("#facturaOrigen").html(facturasList);
                    $("#facturaDestino").html(facturasList);
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
        <img src="../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2"><h4>CREAR NOTA CRÉDITO</h4></div>
    <form id="form1" name="form1" method="post" action="makeNotaC.php">
        <div class="form-group row">
            <label class="col-form-label col-2" for="busClien"><strong>Cliente</strong></label>
            <input type="text" class="form-control col-1" id="busClien" name="busClien"
                   onkeyup="findClienteNotaCr()"
                   required/>
            <div class="col-4" id="myDiv"></div>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2" for="motivo"><strong>Razón de la Nota</strong></label>
            <select name="motivo" size="1" id="motivo" class="form-control col-5">
                <option value="0" selected="">Devolución de Productos</option>
                <option value="1">Descuento no aplicado</option>
            </select>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2" for="facturaOrigen"><strong>Factura origen de la Nota</strong></label>
            <select name="facturaOrigen" id="facturaOrigen" class="form-control col-5" required>
            </select>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2" for="facturaDestino"><strong>Factura destino de la Nota</strong></label>
            <select name="facturaDestino" id="facturaDestino" class="form-control col-5" required>
            </select>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2 text-end" for="fechaNotaC"><strong>Fecha Nota Crédito</strong></label>
            <input type="date" class="form-control col-5" name="fechaNotaC" id="fechaNotaC" required>
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

