<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Seleccionar Orden de Pedido a Anular</title>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>SELECCIONAR ORDEN DE PEDIDO A ANULAR</h4></div>
    <form id="form1" name="form1" method="post" action="anularPedido.php">
        <div class="mb-3 row">
            <label class="form-label col-2" for="idPedido"><strong>Orden de pedido</strong></label>
            <select name="idPedido" id="idPedido" class="form-control col-1" required>
                <option selected disabled value="">------------</option>
                <?php
                $manager = new PedidosOperaciones();
                $pedidos = $manager->getPedidosByEstado(1);
                for ($i = 0; $i < count($pedidos); $i++) : ?>
                    <option value="<?= $pedidos[$i]["idPedido"] ?>"><?= $pedidos[$i]["idPedido"] ?></option>
                <?php
                endfor;
                ?>
            </select>
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
            <button class="button1" onclick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>
