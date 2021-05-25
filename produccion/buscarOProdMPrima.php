<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Modificar consumo de Materia Prima por Orden de Producción de Materia Prima</title>
<script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>

</head>
<body>
<div id="contenedor">
    <div id="saludo"><h4>SELECCIÓN ORDEN DE PRODUCCIÓN DE MATERIA PRIMA A MODIFICAR</h4></div>
    <form id="form1" name="form1" method="post" action="consultaOProdMPrima.php">
        <div class="form-group row">
            <label class="col-form-label col-1 text-right" for="loteMP"><strong>No. de lote</strong></label>
            <input type="text" class="form-control col-2" name="loteMP" id="loteMP"
                   onkeydown="return aceptaNum(event)" required>
        </div>
        <div class="form-group row">
    <div class="col-1 text-center">
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
