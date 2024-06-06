<?php

$RecCajaOperador = new RecCajaOperaciones();
$totalVencido = $RecCajaOperador->getTotalesxCobrarxVencidos();
$totalXVencer1Semana = $RecCajaOperador->getTotalesxCobrarxVenc1sem();
$totalxVencerPlus1Semana = $RecCajaOperador->getTotalesxCobrarxVen8dias();
$total = $totalVencido['totalSaldo'] + $totalXVencer1Semana['totalSaldo'] + $totalxVencerPlus1Semana['totalSaldo'];
?>
<div class="container-fluid">
    <div class="row titulo text-center"><strong>Facturas por cobrar</strong>
    </div>
    <div class="mb-3 row titulo1">
        <div class="col-7 text-end "><strong>Total vencido :</strong></div>
        <div class="col-5 bg-blue"><?= $totalVencido['totalSaldoFormat'] ?></div>
    </div>
    <div class="mb-3 row titulo2">
        <div class="col-7 text-end "><strong>Total a vencer en una semana:</strong></div>
        <div class="col-5 bg-blue"><?= $totalXVencer1Semana['totalSaldoFormat'] ?></div>
    </div>
    <div class="mb-3 row titulo3">
        <div class="col-7 text-end "><strong>Total sin vencer en una semana:</strong></div>
        <div class="col-5 bg-blue"><?= $totalxVencerPlus1Semana['totalSaldoFormat'] ?></div>
    </div>
    <div class="mb-3 row titulo">
        <div class="col-7 text-end "><strong>TOTAL :</strong></div>
        <div class="col-5 bg-blue"><?= '$ ' . number_format($total, 0, '.', ','); ?></div>
    </div>
    <div class="my-4 row">
        <div class="col-5">
            <button class="button" onClick="window.location='ventas/factXcobrar.php'"><span>Ir a cobrar facturas</span>
            </button>
        </div>
    </div>
</div>
