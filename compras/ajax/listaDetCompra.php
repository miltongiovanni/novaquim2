<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}
$idCompra=$_GET['idCompra'];
$tipoCompra=$_GET['tipoCompra'];
spl_autoload_register('cargarClases');
$DetCompraOperador = new DetComprasOperaciones();
$detalle = $DetCompraOperador->getTableDetCompras($idCompra, $tipoCompra);
$titulo = array(
    'draw' => 0,
    'recordsTotal' => count($detalle),
    'recordsFiltered' => count($detalle)
);
$datosRetorno = array(
    $titulo,
    'data' => $detalle
);


print json_encode($datosRetorno);


?>