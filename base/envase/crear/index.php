<?php
include "../../../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <title>Creación de Envase</title>
    <meta charset="utf-8">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script>
        function idEnvase() {
            $.ajax({
                url: '../../../includes/controladorBase.php',
                type: 'POST',
                data: {
                    "action": 'ultimoEnvase'
                },
                dataType: 'text',
                success: function (lastCodEnv) {
                    $("#codEnvase").val(lastCodEnv);
                },
                error: function () {
                    alert("Vous avez un GROS problème");
                }
            });
        }
    </script>
</head>

<body onload="idEnvase();">
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>CREACIÓN DE ENVASE</h4></div>
    <form name="form2" method="POST" action="makeEnv.php">
        <div class="mb-3 row">
            <div class="col-1">
                <label class="form-label " for="codEnvase"><strong>Código</strong></label>
                <input type="text" class="form-control " name="codEnvase" id="codEnvase" maxlength="50">
            </div>
            <div class="col-3">
                <label class="form-label " for="nomEnvase"><strong>Envase</strong></label>
                <input type="text" class="form-control " name="nomEnvase" id="nomEnvase" maxlength="50" required>
            </div>
            <div class="col-1">
                <label class="form-label " for="stockEnvase"><strong>Stock Envase</strong></label>
                <input type="text" class="form-control " name="stockEnvase" id="stockEnvase" onkeydown="return aceptaNum(event)" required>
                <input type="hidden" name="codIva" id="codIva" value="3">
            </div>
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