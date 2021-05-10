<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$remisionOperador = new RemisionesOperaciones();
$remisiones = $remisionOperador->getTableSalidaRemisiones();
$detRemisionOperador = new DetRemisionesOperaciones();
for($i=0;$i<count($remisiones); $i++){
    $remisiones[$i]['detRemision']= $detRemisionOperador->getTableDetRemisionFactura($remisiones[$i]['idRemision']);
}
$titulo = array(
    'draw' => 0,
    'recordsTotal' => count($remisiones),
    'recordsFiltered' => count($remisiones)
);
$datosRetorno = array(
    $titulo,
    'data' => $remisiones
);
print json_encode($datosRetorno);

?>