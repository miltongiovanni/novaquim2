<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Crear Remisión a partir del Pedido</title>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor">
    <div id="saludo"><h4>CREAR REMISIÓN A PARTIR DEL PEDIDO</h4></div>
    <form id="form1" name="form1" method="post" action="remision.php">
        <div class="form-group row">
            <label class="col-form-label col-2" for="lote"><strong>Orden de pedido</strong></label>
            <select name="idPedido" id="idPedido" class="form-control col-1" required>
                <option selected disabled value="">------------</option>
                <?php
                $manager = new PedidosOperaciones();
                $pedidos = $manager->getPedidosByEstado('L');
                for ($i = 0; $i < count($pedidos); $i++) : ?>
                    <option value="<?= $pedidos[$i]["idPedido"] ?>"><?= $pedidos[$i]["idPedido"] ?></option>
                <?php
                endfor;
                ?>
            </select>
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
            <button class="button1" onclick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>
