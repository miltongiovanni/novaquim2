<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');
$fecha=$_GET['fecha'];

$InvMPrimaOperador = new InvMPrimasOperaciones();
$invMPrima = $InvMPrimaOperador->getTableInvMPrimaFecha($fecha);

$datos = [];
for ($i = 0; $i < count($invMPrima); $i++) {
    $datos[$i]['codMP'] = $invMPrima[$i]['codMP'];
    $datos[$i]['nomMPrima'] = $invMPrima[$i]['nomMPrima'];
    $datos[$i]['invtotal'] = $invMPrima[$i]['invtotal'];
    $datos[$i]['entrada'] = $invMPrima[$i]['entrada'];
    $datos[$i]['salida'] = $invMPrima[$i]['salidaProduccion']+ $invMPrima[$i]['salidaEnvDist'];
    $datos[$i]['inventario'] = round($datos[$i]['invtotal'] - $datos[$i]['entrada'] + $datos[$i]['salida'], 3);
}
$titulo = array(
);
$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($datos),
    'recordsFiltered' => count($datos),
    'data' => $datos
);
print json_encode($datosRetorno);

?>