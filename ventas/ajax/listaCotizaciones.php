<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$cotizacionOperador = new CotizacionesOperaciones();
$cotizaciones = $cotizacionOperador->getTableCotizaciones();
for($i=0;$i<count($cotizaciones); $i++){
    $cotizaciones[$i]['productos']= str_replace("1"," Limpieza Equipos",$cotizaciones[$i]['productos']);
    $cotizaciones[$i]['productos']= str_replace("2"," Limpieza General",$cotizaciones[$i]['productos']);
    $cotizaciones[$i]['productos']= str_replace("3"," Mantenimiento de pisos",$cotizaciones[$i]['productos']);
    $cotizaciones[$i]['productos']= str_replace("4"," Productos para Lavandería",$cotizaciones[$i]['productos']);
    $cotizaciones[$i]['productos']= str_replace("5"," Aseo Doméstico y Oficina",$cotizaciones[$i]['productos']);
    $cotizaciones[$i]['productos']= str_replace("6"," Higiene Cocina",$cotizaciones[$i]['productos']);
    $cotizaciones[$i]['productos']= str_replace("7"," Línea Automotriz",$cotizaciones[$i]['productos']);
    $cotizaciones[$i]['distribucion']= str_replace("1"," Implementos de Aseo",$cotizaciones[$i]['productos']);
    $cotizaciones[$i]['distribucion']= str_replace("2"," Desechables",$cotizaciones[$i]['productos']);
    $cotizaciones[$i]['distribucion']= str_replace("3"," Cafetería",$cotizaciones[$i]['productos']);
    $cotizaciones[$i]['distribucion']= str_replace("4"," Abarrotes",$cotizaciones[$i]['productos']);
    $cotizaciones[$i]['distribucion']= str_replace("5"," Distribución Aseo",$cotizaciones[$i]['productos']);
    $cotizaciones[$i]['distribucion']= str_replace("6"," Aseo Personal",$cotizaciones[$i]['productos']);
    $cotizaciones[$i]['distribucion']= str_replace("7"," Hogar",$cotizaciones[$i]['productos']);
    $cotizaciones[$i]['distribucion']= str_replace("8"," Papelería",$cotizaciones[$i]['productos']);
    $cotizaciones[$i]['distribucion']= str_replace("9"," Otros",$cotizaciones[$i]['productos']);
}
$titulo = array(
    'draw' => 0,
    'recordsTotal' => count($cotizaciones),
    'recordsFiltered' => count($cotizaciones)
);
$datosRetorno = array(
    $titulo,
    'data' => $cotizaciones
);
print json_encode($datosRetorno);

?>