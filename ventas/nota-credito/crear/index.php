<?php
include "../../../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Crear Nota Crédito</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/findCliente.js"></script>
    <script>
        function findFacturasCliente(idCliente) {
            $.ajax({
                url: '../../../includes/controladorVentas.php',
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
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>CREAR NOTA CRÉDITO</h4></div>
    <form id="form1" name="form1" method="post" action="makeNotaC.php">
        <div class="mb-3 row">
            <div class="col-4">
                <label class="form-label" for="busClien"><strong>Cliente</strong></label>
                <input type="text" class="form-control" id="busClien" name="busClien" onkeyup="findClienteNotaCr()" required/>
                <div class="mt-2" id="myDiv"></div>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-2">
                <label class="form-label" for="motivo"><strong>Razón de la Nota</strong></label>
                <select name="motivo" size="1" id="motivo" class="form-select">
                    <option value="0" selected="">Devolución de Productos</option>
                    <option value="1">Descuento no aplicado</option>
                </select>
            </div>
            <div class="col-2">
                <label class="form-label" for="fechaNotaC"><strong>Fecha Nota Crédito</strong></label>
                <input type="date" class="form-control" name="fechaNotaC" id="fechaNotaC" required>
            </div>

        </div>
        <div class="mb-3 row">
            <div class="col-2">
                <label class="form-label" for="facturaOrigen"><strong>Factura origen de la Nota</strong></label>
                <select name="facturaOrigen" id="facturaOrigen" class="form-select" required>
                </select>
            </div>
            <div class="col-2">
                <label class="form-label" for="facturaDestino"><strong>Factura destino de la Nota</strong></label>
                <select name="facturaDestino" id="facturaDestino" class="form-select" required>
                </select>
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

