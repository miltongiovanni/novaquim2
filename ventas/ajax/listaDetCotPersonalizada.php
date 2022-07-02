<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}
$idCotPersonalizada=$_GET['idCotPersonalizada'];
spl_autoload_register('cargarClases');
$detCotPersonalizadaOperador = new DetCotizacionPersonalizadaOperaciones();
$detalle = $detCotPersonalizadaOperador->getTableDetCotPersonalizada($idCotPersonalizada);
for($i=0;$i<count($detalle); $i++){
    $detalle[$i]['id'] = $i+1;
}

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($detalle),
    'recordsFiltered' => count($detalle),
    'data' => $detalle
);


print json_encode($datosRetorno);


?>