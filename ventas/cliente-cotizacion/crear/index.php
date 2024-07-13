<?php
include "../../../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Crear cliente cotización</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>CREAR CLIENTE PARA COTIZACIÓN</h4></div>
    <form method="post" action="makeClienCotForm.php" name="form1">
        <div class="row mb-3">
            <div class="col-2">
                <label class="form-label d-block"><strong>Cliente Existente</strong></label>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" name="cliExis" id="cliExis_0" value="1">
                    <label class="form-check-label" for="cliExis_0">Si</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" name="cliExis" id="cliExis_1" value="0">
                    <label class="form-check-label" for="cliExis_1">No</label>
                </div>
            </div>
        </div>
        <div class="mb-3 row">
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
