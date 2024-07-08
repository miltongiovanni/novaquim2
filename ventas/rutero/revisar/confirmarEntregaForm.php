<?php
include "../../../includes/valAcc.php";
$idPedido=$_POST['idPedido'];
$fechaRutero=$_POST['fechaRutero'];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Confirmar entrega de pedido</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
<script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>CONFIRMAR ENTREGA DE PEDIDO</h4></div>
    <form method="post" action="updateEntregaPedido.php" name="form1">
        <div class="mb-3 row">
            <label class="form-label col-1 text-end" for="fechaEntrega"><strong>Pedido: </strong></label>
            <input type="text" class="form-control col-2" name="idPedido" id="idPedido" value="<?=$idPedido?>" readonly>
        </div>
        <div class="mb-3 row">
            <label class="form-label col-1 text-end" for="fechaEntrega"><strong>Fecha entrega: </strong></label>
            <input type="date" class="form-control col-2" name="fechaEntrega" id="fechaEntrega" value="<?=$fechaRutero?>" required>
        </div>
        <div class="mb-3 row">
            <div class="col-1 text-center">
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