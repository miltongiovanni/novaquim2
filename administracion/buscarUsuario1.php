<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Seleccionar Usuario a Asignar Permisos</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
</head>

<body>
<div id="contenedor" class="container-fluid">

    <div id="saludo"><h4>SELECCIONAR USUARIO A ASIGNAR PERMISOS</h4></div>
    <?php
    include "../includes/administracion.php";
    $rep = buscarUsuarioForm("permisos.php", false);
    echo $rep;
    ?>
    <div class="row form-group">
        <div class="col-1">
            <button class="button" onclick="history.back()">
                <span>VOLVER</span></button>
        </div>
    </div>

</div>
</body>

</html>