<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$RecCajaOperador = new RecCajaOperaciones();
$facturas = $RecCajaOperador->getTableFacturasAccClienteXcobrar();
for ($i = 0; $i < count($facturas); $i++) {
    $facturas[$i]['detCarteraCliente'] = $RecCajaOperador->getDetalleFacturasAccClienteXcobrar($facturas[$i]['idCliente']);
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