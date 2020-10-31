<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Seleccionar Remisión a Modificar</title>
    <script src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor">
    <div id="saludo"><strong>BUSCAR REMISIÓN A MODIFICAR</strong></div>

    <form id="form1" name="form1" method="post" action="updateRemisionForm.php">
        <div class="form-group row">
            <label class="col-form-label col-1 text-right" for="idRemision"><strong>Remisión</strong></label>
            <input type="text" class="form-control col-1" name="idRemision" id="idRemision"
                   onKeyPress="return aceptaNum(event)" required>
        </div>
        <div class="form-group row">
            <div class="col-1 text-center">
                <button class="button" type="reset"><span>Reiniciar</span></button>
            </div>
            <div class="col-1 text-center">
                <button class="button" onclick="return Enviar(this.form)"><span>Continuar</span></button>
            </div>
        </div>
    </form>
</div>
</body>
</html>
