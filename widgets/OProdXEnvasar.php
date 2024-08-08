<?php
$manager = new OProdOperaciones();
$ordenes = $manager->getOProdSinEnvasar();
?>
<div class="container-fluid">
    <div class="row titulo text-center"><strong>Órdenes de producción por envasar</strong>
    </div>
    <div class="mb-3 row titulo3">
        <div class="col-2 text-center "><strong>Lote</strong></div>
        <div class="col-7 text-center "><strong>Producto</strong></div>
        <div class="col-3 text-center "><strong>Cantidad</strong></div>
    </div>
    <div style="height: 7.2vw; overflow-y: scroll;overflow-x: hidden;">
        <?php
        foreach ($ordenes as $orden):
        ?>
    <div class="row formatoDatos5">
        <div class="col-2 text-center "><?= $orden['lote'] ?></div>
        <div class="col-7 text-start "><?= $orden['nomProducto'] ?></div>
        <div class="col-3 text-center "><?= round($orden['cantidadKg']).' Kg' ?></div>
    </div>
    <?php
    endforeach;
    ?>
</div>

<div class="my-4 row">
    <div class="col-5">
        <button class="button" type="button" onClick="window.location='produccion/envasado/crear/index.php'">
            <span>Ir a envasado</span>
        </button>
    </div>
</div>
</div>
