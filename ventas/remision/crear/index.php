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
    <title>Crear Remisión a partir del Pedido</title>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>CREAR REMISIÓN A PARTIR DEL PEDIDO</h4></div>
    <form id="form1" name="form1" method="post" action="remision.php">
        <div class="mb-3 row">
            <div class="col-6">
                <label class="form-label" for="idPedido"><strong>Orden de pedido</strong></label>
                <select name="idPedido" id="idPedido" class="form-select" required>
                    <option selected disabled value="">Seleccione una opción</option>
                    <?php
                    $manager = new PedidosOperaciones();
                    $pedidos = $manager->getPedidosByEstado(2);
                    for ($i = 0; $i < count($pedidos); $i++) : ?>
                        <option value="<?= $pedidos[$i]["idPedido"] ?>"><?= $pedidos[$i]["idPedido"].' - '.$pedidos[$i]["nomCliente"].' - '.$pedidos[$i]["nomSucursal"] ?></option>
                    <?php
                    endfor;
                    ?>
                </select>
            </div>
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
