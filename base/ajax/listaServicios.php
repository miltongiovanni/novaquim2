<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$servicioOperador = new ServiciosOperaciones();
$servicios = $servicioOperador->getTableServicios();
$titulo = array(
    'draw' => 0,
    'recordsTotal' => count($servicios),
    'recordsFiltered' => count($servicios)
);
for ($i = 0; $i < count($servicios); $i++) {
    $datos[] = array(
        $servicios[$i]["idServicio"],
        $servicios[$i]["desServicio"],
        $servicios[$i]["iva"],
        $servicios[$i]["coSiigo"]
    );
}
$datosRetorno = array(
    $titulo,
    'data' => $datos
);


print json_encode($datosRetorno);


?>