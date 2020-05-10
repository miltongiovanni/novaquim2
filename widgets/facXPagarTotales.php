<?php

$EgresoOperador = new EgresoOperaciones();
$totalVencido = $EgresoOperador->getTotalesxPagarxVencidos();
$totalXVencer1Semana = $EgresoOperador->getTotalesxPagarxVenc1sem();
$totalxVencerPlus1Semana = $EgresoOperador->getTotalesxPagarxVen8dias();
$total = $totalVencido + $totalXVencer1Semana + $totalxVencerPlus1Semana;
?>
<div class="row titulo"><strong>Facturas por pagar</strong>
</div>
<div class="form-group row titulo1">
    <div class="col-7 text-right "><strong>Total vencido :</strong></div>
    <div class="col-5 bg-blue"><?= '$ '.number_format($totalVencido, 0, '.', ','); ?></div>
</div>
<div class="form-group row titulo2">
    <div class="col-7 text-right "><strong>Total a vencer en una semana:</strong></div>
    <div class="col-5 bg-blue"><?= '$ '.number_format($totalXVencer1Semana, 0, '.', ','); ?></div>
</div>
<div class="form-group row titulo3">
    <div class="col-7 text-right "><strong>Total sin vencer en una semana:</strong></div>
    <div class="col-5 bg-blue"><?= '$ '.number_format($totalxVencerPlus1Semana, 0, '.', ','); ?></div>
</div>
<div class="form-group row titulo">
    <div class="col-7 text-right "><strong>TOTAL :</strong></div>
    <div class="col-5 bg-blue"><?= '$ '.number_format($total, 0, '.', ','); ?></div>
</div>
<div class="form-group row">
    <div class="col-5"><button class="button"  onClick="window.location='compras/factXpagar.php'"><span>Ir a pagar facturas</span></button></div>
</div>