<?php
include "../../../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Modificar consumo de Materia Prima por Orden de Producción</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>

</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>SELECCIÓN ORDEN DE PRODUCCIÓN DE COLOR A MODIFICAR</h4></div>
    <form id="form1" name="form1" method="post" action="consultaOProdColor.php">
        <div class="mb-3 row">
            <label class="form-label col-1 text-end" for="loteColor"><strong>No. de lote</strong></label>
            <input type="text" class="form-control col-2" name="loteColor" id="loteColor"
                   onkeydown="return aceptaNum(event)" required>
        </div>
        <div class="mb-3 row">
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
