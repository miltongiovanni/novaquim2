<?php
include "../../../includes/valAcc.php";
if (isset($_POST['id_cal_mp'])) {
    $id_cal_mp = $_POST['id_cal_mp'];
} else {
    if (isset($_SESSION['id_cal_mp'])) {
        $id_cal_mp = $_SESSION['id_cal_mp'];
    }
}
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$calMatPrimaOperador = new CalMatPrimaOperaciones();
$calidadMPrima = $calMatPrimaOperador->getControlCalidadById($id_cal_mp);
$estadosMPrima = $calMatPrimaOperador->getEstadosMPrimaCalidad();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Detalle Control de Calidad de Materia Prima</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>

</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>CONTROL DE CALIDAD MATERIA PRIMA</h4></div>
    <div class="mb-3 row formatoDatos5">
        <div class="col-3">
            <strong>Materia Prima</strong>
            <div class="bg-blue"><?= $calidadMPrima['nomMPrima'] ?></div>
        </div>
        <div class="col-2">
            <strong>Alias Materia Prima</strong>
            <div class="bg-blue"><?= $calidadMPrima['aliasMPrima'] ?></div>
        </div>
        <div class="col-1">
            <strong>Estado</strong>
            <div class="bg-blue"><?= $calidadMPrima['descripcion'] ?></div>
        </div>
    </div>
    <div class="mb-3 row formatoDatos5">
        <div class="col-1">
            <strong>Lote </strong>
            <div class="bg-blue"><?= $calidadMPrima['lote_mp'] ?></div>
        </div>
        <div class="col-1">
            <strong>Fecha de lote</strong>
            <div class="bg-blue"><?= $calidadMPrima['fecha_lote'] ?></div>
        </div>
        <div class="col-1">
            <strong>Fecha análisis</strong>
            <div class="bg-blue"><?= $calidadMPrima['fecha_analisis'] ?></div>
        </div>
        <div class="col-2">
            <strong>Fecha vencimiento</strong>
            <div class="bg-blue"><?= $calidadMPrima['fecha_vencimiento'] ?></div>
        </div>
        <div class="col-1">
            <strong>Cantidad</strong>
            <div class="bg-blue"><?= $calidadMPrima['cantidad'] ?></div>
        </div>
    </div>
    <div class="mb-3 row titulo">Detalle control de calidad :</div>

    <input type="hidden" name="id" size=55 value="<?= $calidadMPrima['id'] ?>">
    <div class="mb-3 row formatoDatos5">
        <div class="col-1 text-center"><strong>Propiedad</strong></div>
        <div class="col-2 text-center"><strong>Especificación</strong></div>
        <div class="col-1 text-center"><strong>Valor / Cumple</strong></div>
    </div>
    <div class="mb-3 row formatoDatos5 text-center <?= empty($calidadMPrima['pHmPrima']) ? 'd-none' : '' ?>">
        <div class="col-1"><strong>pH</strong></div>
        <div class="col-2 bg-blue"><?= $calidadMPrima['pHmPrima'] . ' ( &plusmn; 0.2 )' ?></div>
        <div class="col-1 "><?= $calidadMPrima['pH_mp'] ?></div>
    </div>
    <div class="mb-3 row formatoDatos5 text-center <?= empty($calidadMPrima['densidadMPrima']) ? 'd-none' : '' ?>">
        <div class="col-1 text-center"><strong>Densidad</strong></div>
        <div class="col-2 bg-blue text-center pe-2"><?= $calidadMPrima['densidadMPrima'] . ' ( &plusmn; 0.1 )' ?></div>
        <div class="col-1"><?= $calidadMPrima['densidad_mp'] ?></div>
    </div>
    <div class="mb-3 row formatoDatos5 text-center <?= empty($calidadMPrima['olorMPrima']) ? 'd-none' : '' ?>">
        <div class="col-1 text-center"><strong>Olor</strong></div>
        <div class="col-2 bg-blue text-center"><?= $calidadMPrima['olorMPrima'] ?></div>
        <div class="col-1"><?= $calidadMPrima['olor_mp'] == 1 ? "CUMPLE" : "NO CUMPLE" ?></div>
    </div>
    <div class="mb-3 row formatoDatos5 text-center <?= empty($calidadMPrima['colorMPrima']) ? 'd-none' : '' ?>">
        <div class="col-1 text-center"><strong>Color</strong></div>
        <div class="col-2 bg-blue text-center"><?= $calidadMPrima['colorMPrima'] ?></div>
        <div class="col-1"><?= $calidadMPrima['color_mp'] == 1 ? "CUMPLE" : "NO CUMPLE" ?></div>
    </div>
    <div class="mb-3 row formatoDatos5 text-center <?= empty($calidadMPrima['aparienciaMPrima']) ? 'd-none' : '' ?>">
        <div class="col-1 text-center"><strong>Apariencia</strong></div>
        <div class="col-2 bg-blue text-center"><?= $calidadMPrima['aparienciaMPrima'] ?></div>
        <div class="col-1"><?= $calidadMPrima['apariencia_mp'] == 1 ? "CUMPLE" : "NO CUMPLE" ?></div>
    </div>
    <div class="mb-3 row formatoDatos5 text-center">
        <div class="col-1 text-center"><strong>Observaciones</strong></div>
        <div class="col-3 px-0">
        <textarea class="form-control" name="observaciones"><?= $calidadMPrima['observaciones'] ?></textarea>
        </div>
    </div>
    <div class="mb-3 row">
        <div class="col-8">
            <div class="mb-3 row justify-content-around">
                <?php if ($calidadMPrima['est_mprima'] != 2) : ?>
                    <div class="col-3">
                        <form action="Imp_etiqueta_cal_mp.php" method="post" target="_blank">
                            <input name="id" type="hidden" value="<?= $calidadMPrima['id']; ?>">
                            <button class="button" type="submit">
                                <span>Imprimir etiqueta</span>
                            </button>
                        </form>
                    </div>
                <?php
                endif;
                ?>
                <div class="col-3">
                    <form action="mod_cal_materia_prima.php" method="post">
                        <input name="id" type="hidden" value="<?= $calidadMPrima['id']; ?>">
                        <button class="button" type="button" onclick="return Enviar(this.form)">
                            <span>Editar control de calidad</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-1">
            <button class="button" onClick="window.location='../../../menu.php'"><span>Ir al Menú</span></button>
        </div>
    </div>
</body>
</html>