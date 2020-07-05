<?php

function cargarClases($classname)
{
    require '../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$fechRef = $_GET['fechRef'];

$MPrimasOperador = new MPrimasOperaciones();
$mPrimas = $MPrimasOperador->getTableMPrimas();
$OProdOperador = new OProdOperaciones();
$OProdColorOperador = new OProdColorOperaciones();
$OProdMPrimaOperador = new OProdMPrimaOperaciones();
$EnvasadoDistOperador = new EnvasadoDistOperaciones();
$datos = [];
for ($i = 0; $i < count($mPrimas); $i++) {
    $datos[$i]['codMPrima'] = $mPrimas[$i]['codMPrima'];
    $datos[$i]['nomMPrima'] = $mPrimas[$i]['nomMPrima'];
    $date = date_create($fechRef);
    date_add($date, date_interval_create_from_date_string('-12 month'));
    for ($j = 1; $j <= 12; $j++) {
        date_add($date, date_interval_create_from_date_string('1 month'));
        $date_month = date_format($date, 'Y-m');
        $dateFormatted = date_format($date, 'Y-m-d');
        $cantProduccion = $OProdOperador->getCantMPrimaAcXMes($dateFormatted, $mPrimas[$i]['codMPrima']);
        $cantProdColor = $OProdColorOperador->getCantMPrimaAcXMes($dateFormatted, $mPrimas[$i]['codMPrima']);
        $cantProdMPrima = $OProdMPrimaOperador->getCantMPrimaAcXMes($dateFormatted, $mPrimas[$i]['codMPrima']);
        $cantEnvDist = $EnvasadoDistOperador->getCantMPrimaAcXMes($dateFormatted, $mPrimas[$i]['codMPrima']);
        $cantidad = $cantProduccion + $cantProdColor + $cantProdMPrima + $cantEnvDist;
        $datos[$i]["$date_month"] = round($cantidad ,1);
    }

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