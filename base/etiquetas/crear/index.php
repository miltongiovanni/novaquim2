<?php
include "../../../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <title>Creación de Etiquetas</title>
    <meta charset="utf-8">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script>
        function idEtiqueta() {
            $.ajax({
                url: '../../../includes/controladorBase.php',
                type: 'POST',
                data: {
                    "action": 'ultimaEtiqueta'
                },
                dataType: 'text',
                success: function (lastCodEtiq) {
                    $("#codEtiqueta").val(lastCodEtiq);
                },
                error: function () {
                    alert("Vous avez un GROS problème");
                }
            });
        }
    </script>
</head>

<body onload="idEtiqueta();">
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>CREACIÓN DE ETIQUETAS</h4></div>
    <form name="form2" method="POST" action="makeEtq.php">
        <div class="form-group row">
            <div class="col-2 text-end">
                <label class="col-form-label " for="codEtiqueta"><strong>Código</strong></label>
            </div>
            <div class="col-2 px-0">
                <input type="text" class="form-control " name="codEtiqueta" id="codEtiqueta" maxlength="50">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-2 text-end">
                <label class="col-form-label " for="nomEtiqueta"><strong>Etiqueta</strong></label>
            </div>
            <div class="col-2 px-0">
                <input type="text" class="form-control " name="nomEtiqueta" id="nomEtiqueta" maxlength="50" required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-2 text-end">
                <label class="col-form-label " for="stockEtiqueta"><strong>Stock Etiqueta</strong></label>
            </div>
            <div class="col-2 px-0">
                <input type="text" class="form-control " name="stockEtiqueta" id="stockEtiqueta"
                       onkeydown="return aceptaNum(event)" required>
                <input type="hidden" name="codIva" id="codIva" value="3">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-1 text-center">
                <button class="button" type="reset"><span>Reiniciar</span></button>
            </div>
            <div class="col-1 text-center">
                <button class="button" type="button"
                        onclick="return Enviar(this.form)"><span>Continuar</span></button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-1">
            <button class="button1" id="back"
                    onClick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>


</div>
</body>

</html>