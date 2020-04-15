<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html>

<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <title>Creación de Envase</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-88">
    <script  src="../js/validar.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script>
    function idEnvase() {
        $.ajax({
		url: '../includes/controladorBase.php',
		type: 'POST',
		data: {
			"action": 'ultimoEnvase'
            },
            dataType: 'text',
            success: function (lastCodEnv) {
                $("#codEnvase").val(lastCodEnv);
            },
            fail: function () {
                alert("Vous avez un GROS problème");
            }
        });
    }
    </script>
</head>

<body onload="idEnvase();">
    <div id="contenedor">
        <div id="saludo"><strong>CREACIÓN DE ENVASE</strong></div>
        <form name="form2" method="POST" action="makeEnv.php">
            <div class="form-group row">
                <label class="col-form-label col-1" style="text-align: right;" for="codEnvase"><strong>Código</strong></label>
                <input type="text" class="form-control col-2" name="codEnvase" id="codEnvase" maxlength="50">
            </div>
            <div class="form-group row">
                <label class="col-form-label col-1" style="text-align: right;" for="nomEnvase"><strong>Envase</strong></label>
                <input type="text" class="form-control col-2" name="nomEnvase" id="nomEnvase" maxlength="50">
            </div>
            <div class="form-group row">
                <label class="col-form-label col-1" style="text-align: right;" for="stockEnvase"><strong>Stock Envase</strong></label>
                <input type="text" class="form-control col-2" name="stockEnvase" id="stockEnvase" onKeyPress="return aceptaNum(event)">
                <input type="hidden" class="form-control col-2" name="codIva" id="codIva" value="3">
            </div>
            <div class="form-group row">
                <div class="col-1" style="text-align: center;">
                    <button class="button"  onclick="return Enviar(this.form)"><span>Continuar</span></button>
                </div>
                <div class="col-1" style="text-align: center;">
                    <button class="button"  type="reset"><span>Reiniciar</span></button>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-1"><button class="button1" id="back"  onClick="history.back()"><span>VOLVER</span></button></div>
        </div>
    </div>
</body>

</html>