<?php
include "../../../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">


<head>
    <meta charset="utf-8">
    <title>Seleccionar Usuario a Actualizar</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script  src="../../../js/validar.js"></script>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div id="contenedor" class="container-fluid">

        <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>SELECCIONAR USUARIO A ACTUALIZAR</h4></div>
        <?php
        include "../../../includes/administracion.php";
        $rep = buscarUsuarioForm("updateUserForm.php", false);
        echo $rep;
        ?>
        
        <div class="row mb-3">
            <div class="col-1"><button class="button1" type="button" onclick="history.back()">
                    <span>VOLVER</span></button></div>
        </div>

    </div>
</body>

</html>