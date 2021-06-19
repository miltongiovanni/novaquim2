<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Remisión de Productos</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo"><h4>REMISIÓN DE PRODUCTOS</h4></div>
    <form method="post" action="makeRemision.php" name="form1">
        <div class="form-group row">
            <label class="col-form-label col-2 text-end" for="cliente"><strong>Cliente</strong></label>
            <input type="text" class="form-control col-2" name="cliente" id="cliente" required>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2 text-end" for="fechaRemision"><strong>Fecha</strong></label>
            <input type="date" class="form-control col-2" name="fechaRemision" id="fechaRemision" required>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2 text-end" for="valor"><strong>Valor</strong></label>
            <input type="text" class="form-control col-2" name="valor" id="valor"
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
            <button class="button1" onClick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>