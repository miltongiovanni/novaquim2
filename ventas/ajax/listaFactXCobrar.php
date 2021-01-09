<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$RecCajaOperador = new RecCajaOperaciones();
$facturas = $RecCajaOperador->getTableFacturasXcobrar();
$datos = [];/*
for ($i = 0; $i < count($compras); $i++) {
    $id = $compras[$i]['id'];
    $tipoCompra = $compras[$i]['tipoCompra'];
    $pago = $EgresoOperador->getPagoXIdTipoCompra($id, $tipoCompra) ;
    $datos[$i]['id'] = $compras[$i]['id'];
    $datos[$i]['tipoCompra'] = $compras[$i]['tipoCompra'];
    $datos[$i]['tipoComp'] = $compras[$i]['tipoComp'];
    $datos[$i]['numFact'] = $compras[$i]['numFact'];
    $datos[$i]['fechComp'] = $compras[$i]['fechComp'];
    $datos[$i]['fechVenc'] = $compras[$i]['fechVenc'];
    $datos[$i]['total'] = "$".number_format($compras[$i]['total'],0,".",",");
    $datos[$i]['subtotal'] = "$".number_format($compras[$i]['subtotal'],0,".",",");
    $datos[$i]['nomProv'] = $compras[$i]['nomProv'];
    $datos[$i]['retefuente'] = "$".number_format($compras[$i]['retefuente'],0,".",",");
    $datos[$i]['reteica'] = "$".number_format($compras[$i]['reteica'],0,".",",");
    $datos[$i]['aPagar'] = "$".number_format(($compras[$i]['total'] - $compras[$i]['retefuente'] - $compras[$i]['reteica']),0,".",",");
    $datos[$i]['pago'] = "$".number_format($pago,0,".",",");
    $datos[$i]['saldo'] = "$".number_format(($compras[$i]['total'] - $pago),0,".",",");
}*/
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