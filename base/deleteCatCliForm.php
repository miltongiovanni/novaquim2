<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Eliminar Tipo de Cliente</title>
    <script  src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor">
    <div id="saludo"><strong>ELIMINACIÓN DE TIPO DE CLIENTE</strong></div>
    <?php
    include "../includes/base.php";
    $rep = buscarCatCliForm("deleteCatCli.php");
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
