<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <title>Creación de Tapas y Válvulas</title>
    <meta charset="utf-8">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script>
        function idTapa() {
            $.ajax({
                url: '../includes/controladorBase.php',
                type: 'POST',
                data: {
                    "action": 'ultimaTapa'
                },
                dataType: 'text',
                success: function (lastCodTap) {
                    $("#codTapa").val(lastCodTap);
                },
                error: function () {
                    alert("Vous avez un GROS problème");
                }
            });
        }
    </script>
</head>

<body onload="idTapa();">
<div id="contenedor">
    <div id="saludo"><strong>CREACIÓN DE TAPAS O VÁLVULAS</strong></div>
    <form name="form2" method="POST" action="makeVal.php">
        <div class="form-group row">
            <label class="col-form-label col-1 text-right" for="codTapa"><strong>Código</strong></label>
            <input type="text" class="form-control col-2" name="codTapa" id="codTapa" maxlength="50">
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1 text-right" for="tapa"><strong>Tapa</strong></label>
            <input type="text" class="form-control col-2" name="tapa" id="tapa" maxlength="50" required>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1 text-right" for="stockTapa"><strong>Stock Tapa</strong></label>
            <input type="text" class="form-control col-2" name="stockTapa" id="stockTapa"
                   onKeyPress="return aceptaNum(event)" required>
            <input type="hidden" class="form-control col-2" name="codIva" id="codIva" value="3">
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
            <button class="button1" id="back" type="button" onClick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>

</div>
</body>

</html>