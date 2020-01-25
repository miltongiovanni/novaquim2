<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html>


<head>
    <meta charset="utf-8">
    <title>Seleccionar Usuario a Actualizar</title>
    <script type="text/javascript" src="../js/validar.js"></script>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div id="contenedor">

        <div id="saludo"><strong>SELECCIONAR USUARIO A ACTUALIZAR</strong></div>
        <?php
        include "../includes/administracion.php";
        $rep = buscarUsuarioForm("updateUserForm.php", false);
        echo $rep;
        ?>
        
        <div class="row form-group">
            <div class="col-1"><button class="button1"  onclick="history.back()">
                    <span>VOLVER</span></button></div>
        </div>

    </div>
</body>

</html>