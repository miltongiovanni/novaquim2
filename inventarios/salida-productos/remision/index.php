<?php
include "../../../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Remisión de Productos</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>REMISIÓN DE PRODUCTOS</h4></div>
    <form method="post" action="makeRemision.php" name="form1">
        <div class="mb-3 row">
            <div class="col-3">
                <label class="form-label" for="cliente"><strong>Cliente</strong></label>
                <input type="text" class="form-control" name="cliente" id="cliente" required>
            </div>
            <div class="col-2">
                <label class="form-label" for="fechaRemision"><strong>Fecha</strong></label>
                <input type="date" class="form-control" name="fechaRemision" id="fechaRemision" required>
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
            <button class="button1" onClick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>