<?php

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');
$tipoCompra = $_GET['tipoCompra'];
$CompraOperador = new ComprasOperaciones();
$DetComprasOperador = new DetComprasOperaciones();
$compras = $CompraOperador->getTableCompras($tipoCompra);

$datos = [];
for ($i = 0; $i < count($compras); $i++) {
    $detCompra = $DetComprasOperador->getTableDetCompras($compras[$i]['idCompra'], $tipoCompra);
    $datos[$i]['idCompra'] = $compras[$i]['idCompra'];
    $datos[$i]['nitProv'] = $compras[$i]['nitProv'];
    $datos[$i]['nomProv'] = $compras[$i]['nomProv'];
    $datos[$i]['numFact'] = $compras[$i]['numFact'];
    $datos[$i]['fechComp'] = $compras[$i]['fechComp'];
    $datos[$i]['fechVenc'] = $compras[$i]['fechVenc'];
    $datos[$i]['descEstado'] = $compras[$i]['descEstado'];
    $datos[$i]['totalCompra'] = $compras[$i]['totalCompra'];
    $datos[$i]['retefuenteCompra'] = $compras[$i]['retefuenteCompra'];
    $datos[$i]['reteicaCompra'] = $compras[$i]['reteicaCompra'];
    $datos[$i]['reteivaCompra'] = $compras[$i]['reteivaCompra'];
    $datos[$i]['vreal'] = $compras[$i]['vreal'];
    $datos[$i]['detCompra'] = $detCompra;
}

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($datos),
    'recordsFiltered' => count($datos),
    'data' => $datos
);
print json_encode($datosRetorno);

?>