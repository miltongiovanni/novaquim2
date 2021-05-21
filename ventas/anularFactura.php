<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Seleccionar Factura a Anular</title>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor">
    <div id="saludo"><strong>INGRESAR FACTURA A ANULAR</strong></div>
    <form id="form1" name="form1" method="post" action="anulaFactura.php">
        <div class="form-group row">
            <label class="col-form-label col-2 text-right" for="idFactura"><strong>No. de Factura</strong></label>
            <input type="text" class="form-control col-3" onkeydown="return aceptaNum(event)" name="idFactura"
                   id="idFactura" required>
        </div>
        <div class="form-group row">
            <label class="col-2 text-right col-form-label" for="observaciones"><strong>Razón de
                    Anulación</strong></label>
            <textarea class="form-control col-3" id="observaciones" name="observaciones" required></textarea>
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
