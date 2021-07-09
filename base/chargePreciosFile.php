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
$uploads_dir = '../uploads/';
if (!is_dir($uploads_dir)) {
    //Directory does not exist, so lets create it.
    mkdir($uploads_dir, 0777, true);
}
$file_name = basename($_FILES['preciosList']["name"]);
$fileNameNoValide = $file_name;
$fileNameNoValide = str_replace(" ", "_", $fileNameNoValide);
$fileNameNoValide = str_replace("'", "-", $fileNameNoValide);
$fileNameNoValide = str_replace(",", "-", $fileNameNoValide);
$tableChars = array(
    'Š' => 'S', 'š' => 's', 'Đ' => 'Dj', 'đ' => 'dj', 'Ž' => 'Z', 'ž' => 'z', 'Ç' => 'C', 'č' => 'c', 'Ć' => 'C', 'ć' => 'c',
    'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'È' => 'E', 'É' => 'E',
    'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O',
    'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss',
    'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e',
    'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o',
    'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'þ' => 'b',
    'ÿ' => 'y', 'Ŕ' => 'R', 'ŕ' => 'r'
);

$fileNameValide = strtr($fileNameNoValide, $tableChars);
$file_tmp_name = $_FILES['preciosList']["tmp_name"];
$upload_file = $uploads_dir . $fileNameValide;
if (move_uploaded_file($file_tmp_name, $upload_file)) {

    /**  Identify the type of $inputFileName  **/
    $inputFileType = IOFactory::identify($upload_file);
    /**  Create a new Reader of the type defined in $inputFileType  **/
    $reader = IOFactory::createReader($inputFileType);
    /**  Advise the Reader that we only want to load cell data  **/
    $reader->setReadDataOnly(true);
    /** Load $upload_file to a Spreadsheet Object  **/
    $spreadsheet = IOFactory::load($upload_file);
    $sheetNames = $spreadsheet->getSheetNames();
    //var_dump($spreadsheet->getSheetNames()); die;
    //$sheetData = $spreadsheet->getSheet(0)->toArray(null, true, true, true);
    //var_dump($sheetData);

} else {
    echo 'error';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <title>Carga de la lista de precios</title>
    <meta charset="utf-8">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>

</head>
<body>
<div id="contenedor" class="container-fluid">

    <div id="saludo">
        <img src="../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2"><h4>SELECCIÓN DE LA PÁGINA A CARGAR</h4></div>
    <form id="form1" name="form1" method="post" action="updatePreciosList.php">
        <input type="hidden" name="upload_file" value="<?=$upload_file?>">
        <div class="form-group row">
            <div class="col-3">
                <select class="form-select" name="page" id="page" aria-label="Default select example" required>
                    <option selected disabled value="">Seleccione una página</option>
                    <?php
                    for ($i=0; $i<count($sheetNames);$i++):
                    ?>
                    <option value="<?=$i ?>"><?=$sheetNames[$i] ?></option>
                    <?php
                    endfor;
                    ?>
                </select>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-1">
                <button class="button" type="button" onclick="return Enviar(this.form)">
                    <span>Continuar</span></button>
            </div>
        </div>
    </form>

    <div class="row form-group">
        <div class="col-1">
            <button class="button1" onclick="history.back()">
                <span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>