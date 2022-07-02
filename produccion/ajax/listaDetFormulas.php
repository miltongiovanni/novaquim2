<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');

$idFormula=$_GET['idFormula'];
$DetFormulaOperador = new DetFormulaOperaciones();
$datos = $DetFormulaOperador->getTableDetFormulas($idFormula);

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($datos),
    'recordsFiltered' => count($datos),
    'data' => $datos
);
print json_encode($datosRetorno);

?>