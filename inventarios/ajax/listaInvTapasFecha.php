<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$fecha = $_GET['fecha'];

$InvTapaOperador = new InvTapasOperaciones();
$invTapa = $InvTapaOperador->getTableInvTapasFecha($fecha);
$datos = [];


for ($i = 0; $i < count($invTapa); $i++) {
    $datos[$i]['codTapa'] = $invTapa[$i]['codTapa'];
    $datos[$i]['tapa'] = $invTapa[$i]['tapa'];
    $datos[$i]['invTapa'] = $invTapa[$i]['invTapa'];
    $datos[$i]['entrada'] = $invTapa[$i]['entradaCompra'] + $invTapa[$i]['entradaCambio'];
    $datos[$i]['salida'] = $invTapa[$i]['salidaProduccion'] + $invTapa[$i]['salidaEnvasadoDist'] +  $invTapa[$i]['salidaJabones'] + $invTapa[$i]['salidaCambios'];
    $datos[$i]['inventario'] = round($datos[$i]['invTapa'] - $datos[$i]['entrada'] + $datos[$i]['salida'], 0);
}

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($datos),
    'recordsFiltered' => count($datos),
    'data' => $datos
);
print json_encode($datosRetorno);

?>