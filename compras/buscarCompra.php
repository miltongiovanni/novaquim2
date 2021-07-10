<?php
include "../includes/valAcc.php";
switch ($tipoCompra) {
    case 1:
        $titulo = ' materias primas';
        break;
    case 2:
        $titulo = ' envases y/o tapas';
        break;
    case 3:
        $titulo = ' etiquetas';
        break;
    case 5:
        $titulo = ' productos de distribución';
        break;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Seleccionar Compra de<?= $titulo ?> a Modificar</title>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>SELECCIONAR COMPRA DE<?= $titulo ?></h4></div>
    <form id="form1" name="form1" method="post" action="updateCompraForm.php">
        <div class="form-group row">
            <label class="col-form-label col-1 text-end" for="idCompra"><strong>No. de compra</strong></label>
            <input type="text" class="form-control col-2" name="idCompra" id="idCompra"
                   onkeydown="return aceptaNum(event)" required>
        </div>
        <div class="form-group row">
                        <div class="col-1 text-center" >
                <button class="button" type="reset"><span>Reiniciar</span></button>
            </div><div class="col-1 text-center" >
                <button class="button" type="button" onclick="return Enviar(this.form)"><span>Continuar</span></button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-1">
            <button class="button1" id="back" onClick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>
