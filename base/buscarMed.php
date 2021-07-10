<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Seleccionar Presentación de Producto</title>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script  src="../js/validar.js"></script>
</head>

<body>
    <div id="contenedor" class="container-fluid">
        <div id="saludo">
        <img src="../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>SELECCIONAR PRESENTACIÓN DE PRODUCTO A MODIFICAR</h4></div>
        <?php
        include "../includes/base.php";
        $rep = buscarPresentacionForm("updateMedForm.php", true);
        echo $rep;
        ?>

        <div class="row form-group">
            <div class="col-1"><button class="button1" onclick="history.back()"><span>VOLVER</span></button></div>
        </div>
    </div>
</body>

</html>