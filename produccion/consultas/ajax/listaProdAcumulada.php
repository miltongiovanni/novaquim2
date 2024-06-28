<?php

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$fechRef = $_GET['fechRef'];

$ProductoOperador = new ProductosOperaciones();
$OProdOperador = new OProdOperaciones();
$productos = $ProductoOperador->getProductos(true);
$datos = [];
for ($i = 0; $i < count($productos); $i++) {
    $datos[$i]['codProducto'] = $productos[$i]['codProducto'];
    $datos[$i]['nomProducto'] = $productos[$i]['nomProducto'];
    $date = date_create($fechRef);
    date_add($date, date_interval_create_from_date_string('-12 month'));
    for ($j = 1; $j <= 12; $j++) {
        date_add($date, date_interval_create_from_date_string('1 month'));
        $date_month = date_format($date, 'Y-m');
        $dateFormatted = date_format($date, 'Y-m-d');
        $cantidad = $OProdOperador->getCantProductoAcXMes($dateFormatted, $productos[$i]['codProducto']);
        $datos[$i]["$date_month"] = $cantidad;
    }

}

$datosRetorno = array(
    'draw' => 0,
    'recordsTotal' => count($datos),
    'recordsFiltered' => count($datos),
    'data' => $datos
);
print json_encode($datosRetorno);

?>