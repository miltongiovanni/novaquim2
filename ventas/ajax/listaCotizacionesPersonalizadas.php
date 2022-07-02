<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$cotizacionOperador = new CotizacionesPersonalizadasOperaciones();
$cotizaciones = $cotizacionOperador->getTableCotizacionesP();
$detCotizacionOperador = new DetCotizacionPersonalizadaOperaciones();
for($i=0;$i<count($cotizaciones); $i++){
    $cotizaciones[$i]['detCotPersonalizada']= $detCotizacionOperador->getDetCotPersonalizada($cotizaciones[$i]['idCotPersonalizada']);
}

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($cotizaciones),
    'recordsFiltered' => count($cotizaciones),
    'data' => $cotizaciones
);
print json_encode($datosRetorno);

?>