<?php

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}
$idPersonal=$_GET['idPersonal'];
$fechaInicial=$_GET['fechaInicial'];
$fechaFinal=$_GET['fechaFinal'];
spl_autoload_register('cargarClases');
$personalOperador = new PersonalOperaciones();
$detalle = $personalOperador->getTableComisionVendedor($idPersonal,$fechaInicial,$fechaFinal );

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($detalle),
    'recordsFiltered' => count($detalle),
    'data' => $detalle
);


print json_encode($datosRetorno);


?>