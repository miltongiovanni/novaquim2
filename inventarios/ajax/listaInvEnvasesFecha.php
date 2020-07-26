<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$fecha = $_GET['fecha'];

$InvEnvaseOperador = new InvEnvasesOperaciones();
$invEnvase = $InvEnvaseOperador->getTableInvEnvaseFecha($fecha);
$datos = [];


for ($i = 0; $i < count($invEnvase); $i++) {
    $datos[$i]['codEnvase'] = $invEnvase[$i]['codEnvase'];
    $datos[$i]['nomEnvase'] = $invEnvase[$i]['nomEnvase'];
    $datos[$i]['invEnvase'] = $invEnvase[$i]['invEnvase'];
    $datos[$i]['entrada'] = $invEnvase[$i]['entradaCompra'] + $invEnvase[$i]['entradaCambio'] + $invEnvase[$i]['entradaDesarmadoKits'];
    $datos[$i]['salida'] = $invEnvase[$i]['salidaProduccion'] + $invEnvase[$i]['salidaEnvasadoDist'] + $invEnvase[$i]['salidaArmadoKits'] + $invEnvase[$i]['salidaJabones'] + $invEnvase[$i]['salidaCambios'];
    $datos[$i]['inventario'] = round($datos[$i]['invEnvase'] - $datos[$i]['entrada'] + $datos[$i]['salida'], 0);
}

$titulo = array(
    'draw' => 0,
    'recordsTotal' => count($datos),
    'recordsFiltered' => count($datos)
);
$datosRetorno = array(
    $titulo,
    'data' => $datos
);
print json_encode($datosRetorno);

?>