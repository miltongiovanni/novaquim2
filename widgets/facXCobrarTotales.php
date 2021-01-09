<?php

$RecCajaOperador = new RecCajaOperaciones();
$totalVencido = $RecCajaOperador->getTotalesxCobrarxVencidos();
$totalXVencer1Semana = $RecCajaOperador->getTotalesxCobrarxVenc1sem();
$totalxVencerPlus1Semana = $RecCajaOperador->getTotalesxCobrarxVen8dias();
$total = $totalVencido['totalSaldo'] + $totalXVencer1Semana['totalSaldo'] + $totalxVencerPlus1Semana['totalSaldo'];
?>
<div class="row titulo"><strong>Facturas por cobrar</strong>
</div>
<div class="form-group row titulo1">
    <div class="col-7 text-right "><strong>Total vencido :</strong></div>
    <div class="col-5 bg-blue"><?= $totalVencido['totalSaldoFormat'] ?></div>
</div>
<div class="form-group row titulo2">
    <div class="col-7 text-right "><strong>Total a vencer en una semana:</strong></div>
    <div class="col-5 bg-blue"><?= $totalXVencer1Semana['totalSaldoFormat'] ?></div>
</div>
<div class="form-group row titulo3">
    <div class="col-7 text-right "><strong>Total sin vencer en una semana:</strong></div>
    <div class="col-5 bg-blue"><?= $totalxVencerPlus1Semana['totalSaldoFormat'] ?></div>
</div>
<div class="form-group row titulo">
    <div class="col-7 text-right "><strong>TOTAL :</strong></div>
    <div class="col-5 bg-blue"><?= '$ ' . number_format($total, 0, '.', ','); ?></div>
</div>
<div class="form-group row">
    <div class="col-5">
        <button class="button" onClick="window.location='ventas/factXcobrar.php'"><span>Ir a cobrar facturas</span>
        </button>
    </div>
</div>