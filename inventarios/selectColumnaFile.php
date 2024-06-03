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
} catch (Exception $e) {
    $ruta = "cargarPrecios.php";
    $mensaje = "Error al actualizar la lista de precios";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <title>Actualización inventario</title>
    <meta charset="utf-8">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>

</head>
<body>
<div id="contenedor" class="container-fluid">

    <div id="saludo">
        <img src="../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>SELECCIÓN DE LAS COLUMNAS PARA
            A CARGAR EL INVENTARIO DE <?= $inventario ?></h4></div>
    <form id="form1" name="form1" method="post" action="updateInventarioList.php">
        <input type="hidden" name="inventario" value="<?= $inventario ?>">
        <input type="hidden" name="upload_file" value="<?= $upload_file ?>">
        <input type="hidden" name="page" value="<?= $page ?>">
        <div class="mb-3 row">
            <label class="form-label col-2 text-end" for="codigo"><strong>Código</strong></label>
            <div class="col-2">
                <select class="form-select" name="codigo" id="codigo" aria-label="Default select example" required>
                    <option selected disabled value="">Seleccione una columna</option>
                    <?php
                    for ($i = 0; $i < count($inventarios[0]); $i++):
                        if (!empty($inventarios[0][$i])):
                            ?>
                            <option value="<?= $i ?>"><?= $inventarios[0][$i] ?></option>
                        <?php
                        endif;
                    endfor;
                    ?>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label class="form-label col-2 text-end" for="codigo"><strong>Cantidad Inventario</strong></label>
            <div class="col-2">
                <select class="form-select" name="cant_inventario" id="cant_inventario"
                        aria-label="Default select example" required>
                    <option selected disabled value="">Seleccione una columna</option>
                    <?php
                    for ($i = 0; $i < count($inventarios[0]); $i++):
                        if (!empty($inventarios[0][$i])):
                            ?>
                            <option value="<?= $i ?>"><?= $inventarios[0][$i] ?></option>
                        <?php
                        endif;
                    endfor;
                    ?>
                </select>
            </div>
        </div>
        <?php
        if ($inventario === 'MATERIA PRIMA' || $inventario === 'PRODUCTO TERMINADO'):
            ?>
            <div class="mb-3 row">
                <label class="form-label col-2 text-end" for="lote"><strong>Lote</strong></label>
                <div class="col-2">
                    <select class="form-select" name="lote" id="lote" aria-label="Default select example" required>
                        <option selected disabled value="">Seleccione una columna</option>
                        <?php
                        for ($i = 0; $i < count($inventarios[0]); $i++):
                            if (!empty($inventarios[0][$i])):
                                ?>
                                <option value="<?= $i ?>"><?= $inventarios[0][$i] ?></option>
                            <?php
                            endif;
                        endfor;
                        ?>
                    </select>
                </div>
            </div>
        <?php
        endif;
        ?>
        <div class="row mb-3">
            <div class="col-1">
                <button class="button" type="button" onclick="return Enviar(this.form)">
                    <span>Continuar</span></button>
            </div>
        </div>
    </form>

    <div class="row mb-3">
        <div class="col-1">
            <button class="button1" onclick="history.back()">
                <span>VOLVER</span></button>
        </div>
    </div>
</div>
<?php


?>
</body>
</html>