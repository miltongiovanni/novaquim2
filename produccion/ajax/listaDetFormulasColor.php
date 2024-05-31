<?php

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');

$idFormulaColor=$_GET['idFormulaColor'];
$DetFormulaColorOperador = new DetFormulaColorOperaciones();
$datos = $DetFormulaColorOperador->getTableDetFormulaColor($idFormulaColor);

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($datos),
    'recordsFiltered' => count($datos),
    'data' => $datos
);
print json_encode($datosRetorno);

?>