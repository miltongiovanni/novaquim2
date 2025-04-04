<?php

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');
$fechaIni = $_GET['fechaIni'];
$fechaFin = $_GET['fechaFin'];

$NotaCrOperador = new NotasCreditoOperaciones();
$notas = $NotaCrOperador->getTableNotasCreditoPorFecha($fechaIni, $fechaFin);

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($notas),
    'recordsFiltered' => count($notas),
    'data' => $notas
);
print json_encode($datosRetorno);

?>