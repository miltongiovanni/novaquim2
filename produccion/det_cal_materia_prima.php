<?php
include "../includes/valAcc.php";
if (isset($_POST['id_cal_mp'])) {
    $id_cal_mp = $_POST['id_cal_mp'];
} else {
    if (isset($_SESSION['id_cal_mp'])) {
        $id_cal_mp = $_SESSION['id_cal_mp'];
    }
}
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
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
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>

</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>CONTROL DE CALIDAD MATERIA PRIMA</h4></div>
    <div class="form-group row">
        <div class="col-1 text-end"><strong>Materia Prima</strong></div>
        <div class="col-3 bg-blue"><?= $calidadMPrima['nomMPrima'] ?></div>
        <div class="col-2 text-end"><strong>Alias Materia Prima</strong></strong></div>
        <div class="col-1 bg-blue"><?= $calidadMPrima['aliasMPrima'] ?></div>
        <div class="col-1 text-end"><strong>Estado</strong></div>
        <div class="col-1 bg-blue"><?= $calidadMPrima['descripcion'] ?></div>
    </div>
    <div class="form-group row">
        <div class="col-1 text-end"><strong>Lote </strong></div>
        <div class="col-1 bg-blue"><?= $calidadMPrima['lote_mp'] ?></div>
        <div class="col-1 text-end"><strong>Fecha de lote</strong></strong></div>
        <div class="col-1 bg-blue"><?= $calidadMPrima['fecha_lote'] ?></div>
        <div class="col-1 text-end"><strong>Fecha análisis</strong></strong></div>
        <div class="col-1 bg-blue"><?= $calidadMPrima['fecha_analisis'] ?></div>
        <div class="col-2 text-end"><strong>Fecha vencimiento</strong></strong></div>
        <div class="col-1 bg-blue"><?= $calidadMPrima['fecha_vencimiento'] ?></div>
        <div class="col-1 text-end"><strong>Cantidad</strong></strong></div>
        <div class="col-1 bg-blue"><?= $calidadMPrima['cantidad'] ?></div>
    </div>
    <div class="form-group row titulo">Detalle control de calidad :</div>

    <input type="hidden" name="id" size=55 value="<?= $calidadMPrima['id'] ?>">
    <div class="form-group row">
        <div class="col-1 text-center"><strong>Propiedad</strong></div>
        <div class="col-2 text-center"><strong>Especificación</strong></div>
        <div class="col-1 text-center"><strong>Valor / Cumple</strong></div>
    </div>
    <div class="form-group row <?= empty($calidadMPrima['pHmPrima']) ? 'd-none' : '' ?>">
        <div class="col-1 text-center col-form-label"><strong>pH</strong></div>
        <div class="col-2 bg-blue text-center col-form-label pe-2"><?= $calidadMPrima['pHmPrima'] . ' ( &plusmn; 0.2 )' ?></div>
        <div class="form-control col-1 mx-2"><?= $calidadMPrima['pH_mp'] ?></div>
    </div>
    <div class="form-group row <?= empty($calidadMPrima['densidadMPrima']) ? 'd-none' : '' ?>">
        <div class="col-1 text-center col-form-label"><strong>Densidad</strong></div>
        <div class="col-2 bg-blue text-center col-form-label pe-2"><?= $calidadMPrima['densidadMPrima'] . ' ( &plusmn; 0.1 )' ?></div>
        <div class="form-control col-1 mx-2"><?= $calidadMPrima['densidad_mp'] ?></div>
    </div>
    <div class="form-group row <?= empty($calidadMPrima['olorMPrima']) ? 'd-none' : '' ?>">
        <div class="col-1 text-center col-form-label"><strong>Olor</strong></div>
        <div class="col-2 bg-blue text-center col-form-label"><?= $calidadMPrima['olorMPrima'] ?></div>
        <div class="form-control col-1 mx-2"><?= $calidadMPrima['olor_mp'] == 1 ? "CUMPLE" : "NO CUMPLE" ?></div>
    </div>
    <div class="form-group row <?= empty($calidadMPrima['colorMPrima']) ? 'd-none' : '' ?>">
        <div class="col-1 text-center col-form-label"><strong>Color</strong></div>
        <div class="col-2 bg-blue text-center col-form-label"><?= $calidadMPrima['colorMPrima'] ?></div>
        <div class="form-control col-1 mx-2"><?= $calidadMPrima['color_mp'] == 1 ? "CUMPLE" : "NO CUMPLE" ?></div>
    </div>
    <div class="form-group row <?= empty($calidadMPrima['aparienciaMPrima']) ? 'd-none' : '' ?>">
        <div class="col-1 text-center col-form-label"><strong>Apariencia</strong></div>
        <div class="col-2 bg-blue text-center col-form-label"><?= $calidadMPrima['aparienciaMPrima'] ?></div>
        <div class="form-control col-1 mx-2"><?= $calidadMPrima['apariencia_mp'] == 1 ? "CUMPLE" : "NO CUMPLE" ?></div>
    </div>
    <div class="form-group row mb-3">
        <div class="col-1 text-center col-form-label"><strong>Observaciones</strong></div>
        <textarea class="form-control col-3 mx-2"
                  name="observaciones"><?= $calidadMPrima['observaciones'] ?></textarea>
    </div>
    <div class="form-group row">
        <div class="col-8">
            <div class="form-group row justify-content-around">
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
            <button class="button" onClick="window.location='../menu.php'"><span>Ir al Menú</span></button>
        </div>
    </div>
</body>
</html>