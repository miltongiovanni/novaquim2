<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}
$idPedido=$_GET['idPedido'];
spl_autoload_register('cargarClases');
$detPedidoOperador = new DetPedidoOperaciones();
$detalle = $detPedidoOperador->getTableDetPedido($idPedido);
for($i=0;$i<count($detalle); $i++){
    $detalle[$i]['id'] = $i+1;
}
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