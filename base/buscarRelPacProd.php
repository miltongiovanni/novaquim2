<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Seleccionar Relación Paca Unidad Producto de Distribución a Actualizar</title>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script  src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor">
    <div id="saludo"><h4>RELACIÓN PACA UNIDAD PRODUCTO DISTRIBUCIÓN A ACTUALIZAR</h4></div>
    <?php
    include "../includes/base.php";
    $rep = buscarRelPacProdForm("updateRelPacProdForm.php", true);
    echo $rep;
    ?>
    <div class="row form-group">
        <div class="col-1">
            <button class="button1" type="button" onclick="history.back()">
                <span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>
