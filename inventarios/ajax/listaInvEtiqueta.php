<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');


$InvEtiquetaOperador = new InvEtiquetasOperaciones();
$etiquetas = $InvEtiquetaOperador->getTableInvEtiqueta();

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($etiquetas),
    'recordsFiltered' => count($etiquetas),
    'data' => $etiquetas
);
print json_encode($datosRetorno);

?>