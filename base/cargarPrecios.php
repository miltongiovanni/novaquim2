<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Seleccionar archivo para actualizar precios</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>

<body>
<div id="contenedor" class="container-fluid">

    <div id="saludo"><h4>SELECCIÓN DEL ARCHIVO A CARGAR</h4></div>
    <form id="form1" name="form1" method="post" action="chargePreciosFile.php" enctype="multipart/form-data">
        <div class="form-group row">
            <input class="form-control col-3" type="file" id="preciosList" name="preciosList" required>
        </div>
        <div class="row form-group">
            <div class="col-1">
                <button class="button" type="button" onclick="return Enviar(this.form)">
                    <span>Continuar</span></button>
            </div>
        </div>
    </form>

    <div class="row form-group">
        <div class="col-1">
            <button class="button1" onclick="history.back()">
                <span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>

</html>