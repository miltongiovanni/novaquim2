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
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>

</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>CONTROL DE CALIDAD MATERIA PRIMA</h4></div>
    <div class="mb-5 row formatoDatos5">
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
    <div class="tabla-50">
        <form id="cal_m_prima_form" class="formatoDatos5" method="POST" action="makeCalMatPrima.php">
            <input type="hidden" name="id" value="<?= $calidadMPrima['id'] ?>">
            <input type="hidden" name="cod_mprima" value="<?= $calidadMPrima['cod_mprima'] ?>">
            <input type="hidden" name="fecha_lote" value="<?= $calidadMPrima['fecha_lote'] ?>">
            <div class="mb-3 row border-bottom pb-2">
                <div class="col-4 text-center "><strong>Propiedad</strong></div>
                <div class="col-4 text-center"><strong>Especificación</strong></div>
                <div class="col-4 text-center "><strong>Valor / Cumple</strong></div>
            </div>
            <div class="mb-3 row">
                <div class="col-4 text-center">
                    <label for="lote_mp" class="form-label"><strong>Lote</strong></label>
                </div>
                <div class="col-4">
                    <div class="bg-blue py-1 px-3"><?= $calidadMPrima['lote_mp'] ?></div>
                </div>
                <div class="col-4">
                    <input type="text" class="form-control" name="lote_mp" id="lote_mp" value="<?= $calidadMPrima['lote_mp'] ?>" readonly>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-4 text-center">
                    <label for="cantidad" class=" form-label"><strong>Cantidad</strong></label>
                </div>
                <div class="col-4">
                    <div class="bg-blue py-1 px-3"><?= $calidadMPrima['cantidad'] ?></div>
                </div>
                <div class="col-4">
                    <input type="text" class="form-control" name="cantidad" id="cantidad" required value="<?= $calidadMPrima['cantidad'] ?>" onkeydown="return aceptaNum(event)">
                </div>
            </div>

            <div class="mb-3 row <?= empty($calidadMPrima['pHmPrima']) ? 'd-none' : '' ?>">
                <div class="col-4 text-center">
                    <label for="pH_mp" class=" form-label"><strong>pH</strong></label>
                </div>
                <div class="col-4">
                    <div class="bg-blue py-1 px-3"><?= $calidadMPrima['pHmPrima'] . ' ( &plusmn; 0.2 )' ?></div>
                </div>
                <div class="col-4">
                    <input type="text" class="form-control" name="pH_mp" id="pH_mp" onkeydown="return aceptaNum(event)">
                </div>

            </div>

            <div class="mb-3 row <?= empty($calidadMPrima['densidadMPrima']) ? 'd-none' : '' ?>">
                <div class="col-4 text-center">
                    <label for="densidad_mp" class="form-label"><strong>Densidad</strong></label>
                </div>
                <div class="col-4">
                    <div class="bg-blue py-1 px-3"><?= $calidadMPrima['densidadMPrima'] . ' ( &plusmn; 0.1 )' ?></div>
                </div>
                <div class="col-4">
                    <input type="text" class="form-control " name="densidad_mp" id="densidad_mp" onkeydown="return aceptaNum(event)">
                </div>
            </div>

            <div class="mb-3 row <?= empty($calidadMPrima['olorMPrima']) ? 'd-none' : '' ?>">
                <div class="col-4 text-center">
                    <label for="olor_mp" class="form-label"><strong>Olor</strong></label>
                </div>
                <div class="col-4">
                    <div class="bg-blue py-1 px-3"><?= $calidadMPrima['olorMPrima'] ?></div>
                </div>
                <div class="col-4">
                    <select name="olor_mp" id="olor_mp" class="form-select text-center">
                        <option value="1" selected>Si</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </div>
            <div class="mb-3 row <?= empty($calidadMPrima['colorMPrima']) ? 'd-none' : '' ?>">
                <div class="col-4 text-center">
                    <label for="color_mp" class="form-label"><strong>Color</strong></label>
                </div>
                <div class="col-4">
                    <div class="bg-blue py-1 px-3"><?= $calidadMPrima['colorMPrima'] ?></div>
                </div>
                <div class="col-4">
                    <select name="color_mp" id="color_mp" class="form-select text-center">
                        <option value="1" selected>Si</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </div>
            <div class="mb-3 row <?= empty($calidadMPrima['aparienciaMPrima']) ? 'd-none' : '' ?>">
                <div class="col-4 text-center">
                    <label for="apariencia_mp" class="form-label"><strong>Apariencia</strong></label>
                </div>
                <div class="col-4">
                    <div class="bg-blue py-1 px-3"><?= $calidadMPrima['aparienciaMPrima'] ?></div>
                </div>
                <div class="col-4">
                    <select name="apariencia_mp" id="apariencia_mp" class="form-select text-center">
                        <option value="1" selected>Si</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </div>

            <div class="mb-3 row">
                <div class="col-4 text-center">
                    <label for="fecha_vencimiento" class="form-label"><strong>Fecha de vencimiento</strong></label>
                </div>
                <div class="col-4 offset-4">
                    <input class="form-control" type="date" name="fecha_vencimiento" value="" id="fecha_vencimiento" required>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-4 text-center">
                    <label for="fecha_analisis" class="form-label"><strong>Fecha análisis</strong></label>
                </div>
                <div class="col-4 offset-4">
                    <input class="form-control" type="date" name="fecha_analisis" value="" id="fecha_analisis" required>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-4 text-center">
                    <label for="est_mprima" class="form-label"><strong>Nuevo estado</strong></label>
                </div>
                <div class="col-4 offset-4">
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
            <div class="mb-3 row">
                <div class="col-4 text-center">
                    <label for="observaciones" class="form-label"><strong>Observaciones</strong></label>
                </div>
                <div class="col-8">
                    <textarea class="form-control" name="observaciones" id="observaciones"></textarea>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-2 text-center">
                    <button class="button" type="reset"><span>Reiniciar</span></button>
                </div>
                <div class="col-2 text-center">
                    <button class="button" type="button" onclick="return Enviar(this.form)"><span>Continuar</span></button>
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        <div class="col-1">
            <button class="button1" onClick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>