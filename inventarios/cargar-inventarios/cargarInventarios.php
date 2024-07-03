<?php
include "../../../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link href="../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Seleccionar archivo para actualizar inventarios</title>
    <script src="../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../js/validar.js"></script>
</head>

<body>
<div id="contenedor" class="container-fluid">

    <div id="saludo">
        <img src="../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>SELECCIÓN DEL ARCHIVO A CARGAR INVENTARIO DE <?=$inventario?></h4></div>
    <form id="form1" name="form1" method="post" action="chargeInventariosFile.php" enctype="multipart/form-data">
        <input type="hidden" name="inventario" value="<?=$inventario?>">
        <div class="mb-3 row">
            <input class="form-control col-4" type="file" id="inventariosList" name="inventariosList" required>
        </div>
        <div class="row mb-3">
            <div class="col-1">
                <button class="button" type="button" onclick="return Enviar(this.form)">
                    <span>Continuar</span></button>
            </div>
        </div>
    </form>

    <div class="row mb-3">
        <div class="col-1">
            <button class="button1" onclick="history.back()">
                <span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>

</html>