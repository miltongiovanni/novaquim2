<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
include "../../../includes/valAcc.php";

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if (is_array($valor)) {
        //echo $nombre_campo.print_r($valor).'<br>';
    } else {
        //echo $nombre_campo . '=' . ${$nombre_campo} . '<br>';
    }
}
$invDistOperador = new InvDistribucionOperaciones();
$invMPOperador = new InvMPrimasOperaciones();
$invEnvaseOperador = new InvEnvasesOperaciones();
$invTapasOperador = new InvTapasOperaciones();
$invProductoOperador = new InvProdTerminadosOperaciones();
$invEtiqOperador = new InvEtiquetasOperaciones();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <title>Actualización inventario</title>
    <meta charset="utf-8">
    <script src="../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../js/validar.js"></script>

</head>
<body>
<?php


    try {
        /**  Identify the type of $inputFileName  **/
        $inputFileType = IOFactory::identify($upload_file);
        /**  Create a new Reader of the type defined in $inputFileType  **/
        $reader = IOFactory::createReader($inputFileType);
        /**  Advise the Reader that we only want to load cell data  **/
        $reader->setReadDataOnly(true);
        /** Load $upload_file to a Spreadsheet Object  **/
        $spreadsheet = IOFactory::load($upload_file);
        $sheetNames = $spreadsheet->getSheetNames();
        $inventarios = $spreadsheet->getSheet($page)->toArray(null, true, false, false);
        if ($inventario === 'PRODUCTOS DE DISTRIBUCIÓN'){

            for($i=1; $i<count($inventarios);$i++){
                $codigoDistribucion = $inventarios[$i][$codigo];
                $invDistribucion = $inventarios[$i][$cant_inventario] ?? 0;
                $datos = array($invDistribucion, $codigoDistribucion );
                $invDistOperador->updateInvDistribucion($datos);
            }
        }
        if ($inventario === 'TAPAS Y VÁLVULAS'){
            for($i=1; $i<count($inventarios);$i++){
                $codigoTapa = $inventarios[$i][$codigo];
                $invTapa = $inventarios[$i][$cant_inventario] ?? 0;
                $datos = array($invTapa, $codigoTapa );
                $invTapasOperador->updateInvTapas($datos);
            }
        }
        if ($inventario === 'ENVASE'){
            for($i=1; $i<count($inventarios);$i++){
                $codigoEnvase = $inventarios[$i][$codigo];
                $invEnvase = $inventarios[$i][$cant_inventario] ?? 0;
                $datos = array($invEnvase, $codigoEnvase );
                $invEnvaseOperador->updateInvEnvase($datos);
            }
        }
        if ($inventario === 'MATERIA PRIMA'){
            for($i=1; $i<count($inventarios);$i++){
                $codigoMPrima = $inventarios[$i][$codigo];
                $loteMPrima = $inventarios[$i][$lote];
                $invMPrima = $inventarios[$i][$cant_inventario] ?? 0;
                $datos = array($invMPrima, $codigoMPrima, $loteMPrima );
                $invMPOperador->updateInvMPrima($datos);
            }
        }
        if ($inventario === 'PRODUCTO TERMINADO'){
            for($i=1; $i<count($inventarios);$i++){
                $codigoPTerminado = $inventarios[$i][$codigo];
                $lotePTerminado = $inventarios[$i][$lote];
                $invPTerminado = $inventarios[$i][$cant_inventario] ?? 0;
                $datos = array($invPTerminado, $codigoPTerminado, $lotePTerminado );
                $invProductoOperador->updateInvProdTerminado($datos);
            }
        }
        if ($inventario === 'ETIQUETAS'){
            for($i=1; $i<count($inventarios);$i++){
                $codigoEtiqueta = $inventarios[$i][$codigo];
                $invEtiqueta = $inventarios[$i][$cant_inventario] ?? 0;
                $datos = array($invEtiqueta, $codigoEtiqueta );
                $invEtiqOperador->updateInvEtiqueta($datos);
            }
        }
        $ruta = "../../../menu.php";
        $mensaje = "Inventario actualizado correctamente";
        $icon = "success";
    } catch (Exception $e) {
        $ruta = "cargarPrecios.php";
        $mensaje = "Error al actualizar la lista de precios";
        $icon = "error";
    } finally {
        unset($conexion);
        unset($stmt);
        unlink($upload_file);
        mover_pag($ruta, $mensaje, $icon);
    }

?>
</body>
</html>