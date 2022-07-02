<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');

$idFormulaMPrima=$_GET['idFormulaMPrima'];
$DetFormulaMPrimaOperador = new DetFormulaMPrimaOperaciones();
$datos = $DetFormulaMPrimaOperador->getTableDetFormulaMPrimas($idFormulaMPrima);


$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($datos),
    'recordsFiltered' => count($datos),
    'data' => $datos
);
print json_encode($datosRetorno);

?>