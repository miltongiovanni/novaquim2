<?php
include "../../../includes/valAcc.php";
$id = $_POST['id'];
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$calMatPrimaOperador = new CalMatPrimaOperaciones();
$calidadMPrima = $calMatPrimaOperador->getControlCalidadById($id);
$estadosMPrima = $calMatPrimaOperador->getEstadosMPrimaCalidad();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Control de calidad Materia Prima</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>

</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>CONTROL DE CALIDAD MATERIA PRIMA</h4></div>
    <div class="mb-5 row">
        <div class="col-1 text-end"><strong>Materia Prima</strong></div>
        <div class="col-3 bg-blue"><?= $calidadMPrima['nomMPrima'] ?></div>
        <div class="col-2 text-end"><strong>Alias Materia Prima</strong></strong></div>
        <div class="col-2 bg-blue"><?= $calidadMPrima['aliasMPrima'] ?></div>
        <div class="col-1 text-end"><strong>Estado</strong></div>
        <div class="col-1 bg-blue"><?= $calidadMPrima['descripcion'] ?></div>
    </div>
    <form id="cal_m_prima_form" method="POST" action="makeCalMatPrima.php">
        <input type="hidden" name="id" value="<?= $calidadMPrima['id'] ?>">
        <input type="hidden" name="cod_mprima" value="<?= $calidadMPrima['cod_mprima'] ?>">
        <input type="hidden" name="fecha_lote" value="<?= $calidadMPrima['fecha_lote'] ?>">
        <div class="form-group row">
            <div class="col-2 text-center "><strong>Propiedad</strong></div>
            <div class="col-2 text-center"><strong>Especificación</strong></div>
            <div class="col-1 text-center "><strong>Valor / Cumple</strong></div>
        </div>
        <div class="row form-group">
            <div class="col-5 border-bottom">
            </div>
        </div>


        <div class="form-group row">
            <label for="lote_mp" class="col-2 text-center col-form-label px-2l"><strong>Lote</strong></label>
            <div class="col-2 bg-blue text-center col-form-label pe-2"><?= $calidadMPrima['lote_mp'] ?></div>
            <div class="col-1 ps-2">
                <input type="text" class="form-control" name="lote_mp" id="lote_mp" value="<?= $calidadMPrima['lote_mp'] ?>" readonly>
            </div>
        </div>
        <div class="form-group row">
            <label for="cantidad" class="col-2 text-center col-form-label px-2"><strong>Cantidad</strong></label>
            <div class="col-2 bg-blue text-center col-form-label pe-2"><?= $calidadMPrima['cantidad'] ?></div>
            <div class="col-1 ps-2">
                <input type="text" class="form-control" name="cantidad" id="cantidad" required value="<?= $calidadMPrima['cantidad'] ?>" onkeydown="return aceptaNum(event)">
            </div>
        </div>

        <div class="form-group row <?= empty($calidadMPrima['pHmPrima']) ? 'd-none' : '' ?>">
            <label for="pH_mp" class="col-2 text-center col-form-label px-2"><strong>pH</strong></label>
            <div class="col-2 bg-blue text-center col-form-label pe-2"><?= $calidadMPrima['pHmPrima'] . ' ( &plusmn; 0.2 )' ?></div>
            <div class="col-1 ps-2">
                <input type="text" class="form-control" name="pH_mp" id="pH_mp" onkeydown="return aceptaNum(event)">
            </div>
        </div>

        <div class="form-group row <?= empty($calidadMPrima['densidadMPrima']) ? 'd-none' : '' ?>">
            <label for="densidad_mp" class="col-2 text-center col-form-label px-2"><strong>Densidad</strong></label>
            <div class="col-2 bg-blue text-center col-form-label pe-2"><?= $calidadMPrima['densidadMPrima'] . ' ( &plusmn; 0.1 )' ?></div>
            <div class="col-1 ps-2">
                <input type="text" class="form-control " name="densidad_mp" id="densidad_mp" onkeydown="return aceptaNum(event)">
            </div>
        </div>


        <div class="form-group row <?= empty($calidadMPrima['olorMPrima']) ? 'd-none' : '' ?>">
            <label for="olor_mp" class="col-2 text-center col-form-label px-2"><strong>Olor</strong></label>
            <div class="col-2 bg-blue text-center col-form-label pe-2"><?= $calidadMPrima['olorMPrima'] ?></div>
            <div class="col-1 ps-2">
                <select name="olor_mp" id="olor_mp" class="form-select text-center">
                    <option value="1" selected>Si</option>
                    <option value="0">No</option>
                </select>
            </div>
        </div>


        <div class="form-group row <?= empty($calidadMPrima['colorMPrima']) ? 'd-none' : '' ?>">
            <label for="color_mp" class="col-2 text-center col-form-labe px-2"><strong>Color</strong></label>
            <div class="col-2 bg-blue text-center col-form-label pe-2"><?= $calidadMPrima['colorMPrima'] ?></div>
            <div class="col-1 ps-2">
                <select name="color_mp" id="color_mp" class="form-select text-center">
                    <option value="1" selected>Si</option>
                    <option value="0">No</option>
                </select>
            </div>
        </div>


        <div class="form-group row <?= empty($calidadMPrima['aparienciaMPrima']) ? 'd-none' : '' ?>">
            <label for="apariencia_mp" class="col-2 text-center col-form-label px-2"><strong>Apariencia</strong></label>
            <div class="col-2 bg-blue text-center col-form-label pe-2"><?= $calidadMPrima['aparienciaMPrima'] ?></div>
            <div class="col-1 ps-2">
                <select name="apariencia_mp" id="apariencia_mp" class="form-select text-center">
                    <option value="1" selected>Si</option>
                    <option value="0">No</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="fecha_vencimiento" class="col-2 text-center col-form-label px-2"><strong>Fecha de vencimiento</strong></label>
            <input class="form-control col-3 px-2" type="date" name="fecha_vencimiento" value="" id="fecha_vencimiento" required>
        </div>
        <div class="form-group row">
            <label for="fecha_analisis" class="col-2 text-center col-form-label px-2"><strong>Fecha análisis</strong></label>
            <input class="form-control col-3 px-2" type="date" name="fecha_analisis" value="" id="fecha_analisis" required>
        </div>
        <div class="form-group row">
            <label for="est_mprima" class="col-2 text-center col-form-label px-2"><strong>Nuevo estado</strong></label>
            <div class="col-3 ps-2">
                <select name="est_mprima" id="est_mprima" class="form-select text-center">
                    <?php
                    foreach ($estadosMPrima as $estado):
                        ?>
                        <option value="<?= $estado['id'] ?>" <?= $estado['id'] == $calidadMPrima['est_mprima'] ? 'selected' : '' ?>><?= $estado['descripcion'] ?></option>
                    <?php
                    endforeach;
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="observaciones" class="col-2 text-center col-form-label px-2"><strong>Observaciones</strong></label>
            <textarea class="form-control col-3 px-2" name="observaciones" id="observaciones"></textarea>
        </div>
        <div class="form-group row">
            <div class="col-1 text-center">
                <button class="button" type="reset"><span>Reiniciar</span></button>
            </div>
            <div class="col-1 text-center">
                <button class="button" type="button" onclick="return Enviar(this.form)"><span>Continuar</span></button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-1">
            <button class="button1" onClick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>