<?php
include "../../../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Seleccionar Comprobante de Egreso a consultar</title>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
<script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>SELECCIONAR COMPROBANTE DE EGRESO A CONSULTAR</h4></div>
    <form id="form1" name="form1" method="post" action="consultaEgreso.php">
        <div class="mb-3 row">
            <div class="col-2">
                <label class="form-label" for="idEgreso"><strong>No. de egreso</strong></label>
                <input type="text" class="form-control" name="idEgreso" id="idEgreso"
                       onkeydown="return aceptaNum(event)" required>
            </div>
        </div>
        <div class="mb-3 row"><div class="col-1 text-center">
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
