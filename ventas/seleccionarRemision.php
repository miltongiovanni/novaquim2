<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Seleccionar Remisión a consultar</title>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor">
    <div id="saludo"><strong>SELECCIONAR REMISIÓN A CONSULTAR</strong></div>
    <form id="form1" name="form1" method="post" action="consultaRemision.php">
        <div class="form-group row">
            <label class="col-form-label col-2 text-right" for="idRemision"><strong>No. de remisión</strong></label>
            <input type="text" class="form-control col-1" name="idRemision" id="idRemision"
                   onkeydown="return aceptaNum(event)" required>
        </div>
        <div class="form-group row"><div class="col-1 text-center">
                <button class="button" type="reset"><span>Reiniciar</span></button>
            </div>
            <div class="col-1 text-center">
                <button class="button" type="button" onclick="return Enviar(this.form)"><span>Continuar</span></button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-1">
            <button class="button1" id="back" onClick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>