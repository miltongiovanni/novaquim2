<?php

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');

$codPresentacion = $_GET['codPresentacion'];
$loteProd = $_GET['loteProd'];
$invProdTerminadoOperador = new InvProdTerminadosOperaciones();
$salidas = $invProdTerminadoOperador->getDetRemisionTrazabilidad($codPresentacion, $loteProd );

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($salidas),
    'recordsFiltered' => count($salidas),
    'data' => $salidas
);
print json_encode($datosRetorno);

?>