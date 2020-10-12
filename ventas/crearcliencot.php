<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Crear cliente cotización</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../js/validar.js"></script>
<body>
<div id="contenedor">
    <div id="saludo"><strong>CREAR CLIENTE PARA COTIZACIÓN</strong></div>
    <form method="post" action="makeClienCotForm.php" name="form1">
        <div class="row mb-3">
            <label class="col-form-label col-2 text-right "><strong>Cliente Existente</strong></label>
            <div class="col-1">
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="cliExis" id="cliExis_0" value="1">Si
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="cliExis" id="cliExis_1" value="0">No
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-1 text-center">
                <button class="button" onclick="return Enviar(this.form)"><span>Continuar</span></button>
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
