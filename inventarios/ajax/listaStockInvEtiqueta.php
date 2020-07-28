<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');


$InvEtiquetaOperador = new InvEtiquetasOperaciones();
$etiquetas = $InvEtiquetaOperador->getTableStockInvEtiqueta();

$titulo = array(
    'draw' => 0,
    'recordsTotal' => count($etiquetas),
    'recordsFiltered' => count($etiquetas)
);
$datosRetorno = array(
    $titulo,
    'data' => $etiquetas
);
print json_encode($datosRetorno);

?>