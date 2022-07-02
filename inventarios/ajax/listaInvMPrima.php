<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');


$InvMPrimaOperador = new InvMPrimasOperaciones();
$invMPrima = $InvMPrimaOperador->getTableInvMPrima();

$datos = [];
for ($i = 0; $i < count($invMPrima); $i++) {
    $detInvMPrima = $InvMPrimaOperador->getDetInv($invMPrima[$i]['codMP']);
    $datos[$i]['codMP'] = $invMPrima[$i]['codMP'];
    $datos[$i]['nomMPrima'] = $invMPrima[$i]['nomMPrima'];
    $datos[$i]['invtotal'] = $invMPrima[$i]['invtotal'];
    $datos[$i]['detInvMPrima'] = $detInvMPrima;
}

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($datos),
    'recordsFiltered' => count($datos),
    'data' => $datos
);
print json_encode($datosRetorno);

?>