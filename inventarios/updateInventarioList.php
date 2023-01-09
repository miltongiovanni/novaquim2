<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
include "../includes/valAcc.php";

function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
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
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <title>Actualización lista de precios</title>
    <meta charset="utf-8">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>

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
        if (stristr($sheetNames[$page], 'distribucion')){
            for($i=1; $i<count($inventarios);$i++){
                $datos = array($inventarios[$i][5], $inventarios[$i][0] );
                $invDistOperador->updateInvDistribucion($datos);
            }
        }
        if (stristr($sheetNames[$page], 'tapas')){
            for($i=1; $i<count($inventarios);$i++){
                $datos = array($inventarios[$i][2], $inventarios[$i][0] );
                $invTapasOperador->updateInvTapas($datos);
            }
        }
        if (stristr($sheetNames[$page], 'envase')){
            for($i=1; $i<count($inventarios);$i++){
                $datos = array($inventarios[$i][2], $inventarios[$i][0] );
                $invEnvaseOperador->updateInvEnvase($datos);
            }
        }
        if (stristr($sheetNames[$page], 'mp')){
            for($i=1; $i<count($inventarios);$i++){
                $datos = array($inventarios[$i][3], $inventarios[$i][0], $inventarios[$i][2] );
                $invMPOperador->updateInvMPrima($datos);
            }
        }
        if (stristr($sheetNames[$page], 'terminado')){
            for($i=1; $i<count($inventarios);$i++){
                $datos = array($inventarios[$i][3], $inventarios[$i][0], $inventarios[$i][2] );
                $invProductoOperador->updateInvProdTerminado($datos);
            }
        }
        if (stristr($sheetNames[$page], 'etiquetas')){
            for($i=1; $i<count($inventarios);$i++){
                $datos = array($inventarios[$i][2], $inventarios[$i][0] );
                $invEtiqOperador->updateInvEtiqueta($datos);
            }
        }
        $ruta = "../menu.php";
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