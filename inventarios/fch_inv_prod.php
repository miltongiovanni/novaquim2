<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Consulta de Inventario por Fecha</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script  src="../js/validar.js"></script>
</head>
<body> 
<div id="contenedor">
<div id="saludo"><strong>CONSULTA DE INVENTARIO POR FECHA</strong></div> 
<form method="post" action="inv_prod_fch.php" name="form1">
    <div class="form-group row">
        <label class="col-form-label col-1 text-right" for="fecha"><strong>Fecha</strong></label>
        <input type="date" class="form-control col-2" name="fecha" id="fecha" required>
    </div>
    <div class="form-group row">
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