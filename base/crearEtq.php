<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html>

<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <title>Creación de Etiquetas</title>
    <meta charset="utf-8">
    <script  src="../js/validar.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script>
        function idEtiqueta() {
            $.ajax({
                url: '../includes/controladorBase.php',
                type: 'POST',
                data: {
                    "action": 'ultimaEtiqueta'
                },
                dataType: 'text',
                success: function (lastCodEtiq) {
                    $("#codEtiqueta").val(lastCodEtiq);
                },
                fail: function () {
                    alert("Vous avez un GROS problème");
                }
            });
        }
    </script>
</head>

<body onload="idEtiqueta();">
    <div id="contenedor">
        <div id="saludo"><strong>CREACIÓN DE ETIQUETAS</strong></div>
        <form name="form2" method="POST" action="makeEtq.php">
            <div class="form-group row">
                <label class="col-form-label col-2"
                    for="codEtiqueta"><strong>Código</strong></label>
                <input type="text" class="form-control col-2" name="codEtiqueta" id="codEtiqueta" maxlength="50">
            </div>
            <div class="form-group row">
                <label class="col-form-label col-2"
                    for="nomEtiqueta"><strong>Etiqueta</strong></label>
                <input type="text" class="form-control col-2" name="nomEtiqueta" id="nomEtiqueta" maxlength="50">
            </div>
            <div class="form-group row">
                <label class="col-form-label col-2"  for="stockEtiqueta"><strong>Stock
                        Etiqueta</strong></label>
                <input type="text" class="form-control col-2" name="stockEtiqueta" id="stockEtiqueta"
                    onKeyPress="return aceptaNum(event)">
                <input type="hidden" class="form-control col-2" name="codIva" id="codIva" value="3">
            </div>
            <div class="form-group row">
                <div class="col-1 text-center" >
                    <button class="button" 
                        onclick="return Enviar(this.form)"><span>Continuar</span></button>
                </div>
                <div class="col-1 text-center" >
                    <button class="button"  type="reset"><span>Reiniciar</span></button>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-1"><button class="button1" id="back" 
                    onClick="history.back()"><span>VOLVER</span></button></div>
        </div>


    </div>
</body>

</html>