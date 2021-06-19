<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Desactivar Cliente</title>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/findCliente.js"></script>
</head>


<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo"><h4>SELECCIONAR CLIENTE A DESACTIVAR</h4></div>
    <?php
    include "../includes/ventas.php";
    $rep = buscarClienteForm("deleteCli.php");
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
