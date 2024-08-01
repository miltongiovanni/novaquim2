<?php
include "../../../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Consulta de facturas por Fecha</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
<script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>CONSULTA DE FACTURAS POR FECHA</h4></div>
    <form method="post" action="listarConsFacturas.php" name="form1">
        <div class="mb-3 row">
            <div class="col-2">
                <label class="form-label" for="fechaIni"><strong>Fecha inicial: </strong></label>
                <input type="date" class="form-control" name="fechaIni" id="fechaIni" required>
            </div>
            <div class="col-2">
                <label class="form-label" for="fechaFin"><strong>Fecha final: </strong></label>
                <input type="date" class="form-control" name="fechaFin" id="fechaFin" required>
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