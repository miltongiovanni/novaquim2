<?php

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$fecha = $_GET['fecha'];

$InvDistribucionOperador = new InvDistribucionOperaciones();
$invdistribucion = $InvDistribucionOperador->getTableInvDistribucionFecha($fecha);
$datos = [];


for ($i = 0; $i < count($invdistribucion); $i++) {
    $datos[$i]['codDistribucion'] = $invdistribucion[$i]['codDistribucion'];
    $datos[$i]['producto'] = $invdistribucion[$i]['producto'];
    $datos[$i]['invDistribucion'] = $invdistribucion[$i]['invDistribucion'];
    $datos[$i]['entrada'] = $invdistribucion[$i]['entradaCompras'] + $invdistribucion[$i]['entradaArmKits'] + $invdistribucion[$i]['entradaDesarmKits'] + $invdistribucion[$i]['entradaEnvDistribucion'];
    $datos[$i]['salida'] = $invdistribucion[$i]['salidaVentas'] + $invdistribucion[$i]['salidaRemision'] + $invdistribucion[$i]['salidaDesarmadoKits'] + $invdistribucion[$i]['salidaArmadoKits'];
    $datos[$i]['inventario'] = round($datos[$i]['invDistribucion'] - $datos[$i]['entrada'] + $datos[$i]['salida'], 0);
}

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($datos),
    'recordsFiltered' => count($datos),
    'data' => $datos
);
print json_encode($datosRetorno);

?>