<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Seleccionar Pedido a consultar</title>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor">
    <div id="saludo"><strong>SELECCIONAR PEDIDO A CONSULTAR</strong></div>
    <form id="form1" name="form1" method="post" action="consultaPedido.php">
        <div class="form-group row">
            <label class="col-form-label col-1 text-right" for="idPedido"><strong>No. de pedido</strong></label>
            <input type="text" class="form-control col-2" name="idPedido" id="idPedido"
                   onKeyPress="return aceptaNum(event)" required>
        </div>
        <div class="form-group row"><div class="col-1 text-center">
                <button class="button" type="reset"><span>Reiniciar</span></button>
            </div>
            <div class="col-1 text-center">
                <button class="button" onclick="return Enviar(this.form)"><span>Continuar</span></button>
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