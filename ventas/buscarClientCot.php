<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Seleccionar Cliente de Cotización a Modificar</title>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/findCliente.js"></script>

</head>
<body>
<div id="contenedor">
    <div id="saludo"><strong>SELECCIONAR CLIENTE DE COTIZACIÓN A MODIFICAR</strong></div>
    <form id="form1" name="form1" method="post" action="updateCliCotForm.php">
        <div class="form-group row">
            <label class="col-form-label col-2" for="busClien"><strong>Cliente</strong></label>
            <input type="text" class="form-control col-2" id="busClien" name="busClien"
                   onkeyup="findClienteCotizacion()"
                   required/>
        </div>
        <div class="form-group row">
            <div class="col-4" id="myDiv">
            </div>
        </div>
        <div class="row form-group">
            <div class="col-1">
                <button class="button" onclick="return Enviar(this.form)">
                    <span>Continuar</span></button>
            </div>
        </div>
    </form>

    <div class="row form-group">
        <div class="col-1">
            <button class="button1" onclick="history.back()">
                <span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>

