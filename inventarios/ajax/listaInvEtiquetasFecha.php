<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$fecha = $_GET['fecha'];

$InvEtiquetaOperador = new InvEtiquetasOperaciones();
$invEtiqueta = $InvEtiquetaOperador->getTableInvEtiquetaFecha($fecha);
$datos = [];


for ($i = 0; $i < count($invEtiqueta); $i++) {
    $datos[$i]['codEtiq'] = $invEtiqueta[$i]['codEtiq'];
    $datos[$i]['nomEtiqueta'] = $invEtiqueta[$i]['nomEtiqueta'];
    $datos[$i]['invEtiq'] = $invEtiqueta[$i]['invEtiq'];
    $datos[$i]['entrada'] = $invEtiqueta[$i]['entradaCompra'] + $invEtiqueta[$i]['entradaCambio'] ;
    $datos[$i]['salida'] = $invEtiqueta[$i]['salidaProduccion']  + $invEtiqueta[$i]['salidaJabones'] + $invEtiqueta[$i]['salidaCambios'];
    $datos[$i]['inventario'] = round($datos[$i]['invEtiq'] - $datos[$i]['entrada'] + $datos[$i]['salida'], 0);
}

$titulo = array(
    'draw' => 0,
    'recordsTotal' => count($datos),
    'recordsFiltered' => count($datos)
);
$datosRetorno = array(
    $titulo,
    'data' => $datos
);
print json_encode($datosRetorno);

?>