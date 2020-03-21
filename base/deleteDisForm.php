<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Eliminar Producto de Distribución</title>
    <script type="text/javascript" src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor">
    <div id="saludo"><strong>ELIMINACIÓN DE PRODUCTO DE DISTRIBUCIÓN</strong></div>
    <?php
    include "../includes/base.php";
    $rep = buscarProductoDistribucionForm("deleteDis.php", false);
    echo $rep;
    ?>
    <div class="row form-group">
        <div class="col-1">
            <button class="button1" onclick="history.back()">
                <span>VOLVER</span></button>
        </div>
    </div>

</div>
</body>
</html>
