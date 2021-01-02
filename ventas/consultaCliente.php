<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Consulta facturas por cliente</title>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../js/validar.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/findCliente.js"></script>

</head>
<body>
<div id="contenedor">
    <div id="saludo"><strong>CONSULTA DE FACTURAS POR CLIENTE</strong></div>

    <?php
    include "../includes/ventas.php";
    $rep = buscarClienteForm("listarFacturasCliente.php");
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

