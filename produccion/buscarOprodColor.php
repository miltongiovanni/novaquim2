<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css"><head>
<meta charset="utf-8">
<title>Modificar consumo de Materia Prima por Orden de Producción</title>
<script  src="../js/validar.js"></script>

</head>
<body>
<div id="contenedor">
<div id="saludo"><strong>SELECCIÓN ORDEN DE PRODUCCIÓN DE COLOR A MODIFICAR</strong></div>
<form id="form1" name="form1" method="post" action="consultaOProdColor.php">
    <div class="form-group row">
        <label class="col-form-label col-1 text-right" for="loteColor"><strong>No. de lote</strong></label>
        <input type="text" class="form-control col-2" name="loteColor" id="loteColor"
               onKeyPress="return aceptaNum(event)">
    </div>
    <div class="form-group row">
        <div class="col-1 text-center">
            <button class="button" onclick="return Enviar(this.form)"><span>Continuar</span></button>
        </div>
        <div class="col-1 text-center">
            <button class="button" type="reset"><span>Reiniciar</span></button>
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