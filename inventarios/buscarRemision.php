<?php
include "../../../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Seleccionar Remisión a Modificar</title>
<script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>BUSCAR REMISIÓN A MODIFICAR</h4></div>

    <form id="form1" name="form1" method="post" action="updateRemisionForm.php">
        <div class="form-group row">
            <label class="col-form-label col-1 text-end" for="idRemision"><strong>Remisión</strong></label>
            <input type="text" class="form-control col-1" name="idRemision" id="idRemision"
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
</div>
</body>
</html>
