<?php
$pedidoOperador = new PedidosOperaciones();
$pedidos = $pedidoOperador->getTablePedidos('1','', '', '', '');
?>
<div class="container-fluid">
    <div class="row titulo text-center"><strong>Pedidos pendientes</strong>
    </div>
    <div class="mb-3 row titulo3">
        <div class="col-2 text-center "><strong>Pedido</strong></div>
        <div class="col-7 text-center "><strong>Sucursal Cliente</strong></div>
        <div class="col-3 text-center "><strong>F. Entrega</strong></div>
    </div>
    <div style="height: 7.2vw; overflow-y: scroll;overflow-x: hidden;">
        <?php
        foreach ($pedidos as $pedido):
        ?>
    <div class="row formatoDatos5">
        <div class="col-2 text-center "><?= $pedido['idPedido'] ?></div>
        <div class="col-7 text-start "><?= $pedido['nomSucursal'] ?></div>
        <div class="col-3 text-center "><?= $pedido['fechaEntrega'] ?></div>
    </div>
    <?php
    endforeach;
    ?>
</div>

<div class="my-4 row">
    <div class="col-5">
        <button class="button" type="button" onClick="window.location='ventas/buscarPedido.php'">
            <span>Ir a modificar pedido</span>
        </button>
    </div>
</div>
</div>
