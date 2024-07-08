<?php
include "../../../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Seleccionar Cliente de Cotización a Modificar</title>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/findCliente.js"></script>

</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>SELECCIONAR CLIENTE DE COTIZACIÓN A MODIFICAR</h4></div>
    <form id="form1" name="form1" method="post" action="updateCliCotForm.php">
        <div class="mb-3 row">
            <label class="form-label col-2" for="busClien"><strong>Cliente</strong></label>
            <input type="text" class="form-control col-2" id="busClien" name="busClien"
                   onkeyup="findClienteCotizacion()"
                   required/>
        </div>
        <div class="mb-3 row">
            <div class="col-4" id="myDiv">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-1">
                <button class="button" type="button" onclick="return Enviar(this.form)">
                    <span>Continuar</span></button>
            </div>
        </div>
    </form>

    <div class="row mb-3">
        <div class="col-1">
            <button class="button1" onclick="history.back()">
                <span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>

