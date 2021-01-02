<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idCliente=$_GET['idCliente'];
$facturaOperador = new FacturasOperaciones();
$facturas = $facturaOperador->getTableFacturasCliente($idCliente);
$detFacturaOperador = new DetFacturaOperaciones();
for($i=0;$i<count($facturas); $i++){
    $facturas[$i]['detFactura']= $detFacturaOperador->getDetFactura($facturas[$i]['idFactura']);
}
$titulo = array(
    'draw' => 0,
    'recordsTotal' => count($facturas),
    'recordsFiltered' => count($facturas)
);
$datosRetorno = array(
    $titulo,
    'data' => $facturas
);
print json_encode($datosRetorno);

?>