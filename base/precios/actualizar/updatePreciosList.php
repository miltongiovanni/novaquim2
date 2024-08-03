<?php
require '../../../vendor/autoload.php';

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
$preciosOperador = new PreciosOperaciones();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <title>Actualización lista de precios</title>
    <meta charset="utf-8">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>

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
//var_dump($spreadsheet->getSheetNames()); die;
    $precios = $spreadsheet->getSheet($page)->toArray(null, true, false, false);
    for ($i = 1; $i < count($precios); $i++) {
        $datos = array($precios[$i][2], $precios[$i][3], $precios[$i][4], $precios[$i][5], $precios[$i][6], $precios[$i][0]);
        $preciosOperador->updateListaPrecio($datos);
    }
    $ruta = "../lista/";
    $mensaje = "Lista de precios actualizada correctamente";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "/base/precios/actualizar";
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