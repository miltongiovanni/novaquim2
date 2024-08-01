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
    <title>Modificación calidad materia prima</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>

</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>EDICIÓN DEL CONTROL DE CALIDAD MATERIA PRIMA</h4></div>
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
        <form name="form2" class="formatoDatos5" method="POST" action="updateCalMateriaPrima.php">
            <input type="hidden" name="id" value="<?= $calidadMPrima['id'] ?>">
            <input type="hidden" name="cod_mprima" value="<?= $calidadMPrima['cod_mprima'] ?>">
            <div class="mb-3 row border-bottom pb-2">
                <div class="col-4 text-center"><strong>Propiedad</strong></div>
                <div class="col-4 text-center"><strong>Especificación</strong></div>
                <div class="col-4 text-center"><strong>Valor / Cumple</strong></div>
            </div>
            <div class="mb-3 row">
                <label for="cantidad" class="col-4 text-center py-1"><strong>Cantidad</strong></label>
                <div class="col-4 bg-blue py-1 px-3"><?= $calidadMPrima['cantidad'] ?> kg</div>
                <div class="col-4">
                    <input type="text" class="form-control" name="cantidad" id="cantidad" required value="<?= $calidadMPrima['cantidad'] ?>" readonly>
                </div>
            </div>
            <div class="mb-3 row <?= empty($calidadMPrima['pHmPrima']) ? 'd-none' : '' ?>">
                <label for="pH_mp" class="col-4 text-center py-1"><strong>pH</strong></label>
                <div class="col-4 bg-blue py-1 px-3"><?= $calidadMPrima['pHmPrima'] . ' ( &plusmn; 0.2 )' ?></div>
                <div class="col-4">
                    <input type="text" class="form-control" name="pH_mp" id="pH_mp" onkeydown="return aceptaNum(event)" value="<?= $calidadMPrima['pH_mp'] ?>">
                </div>
            </div>
            <div class="mb-3 row <?= empty($calidadMPrima['densidadMPrima']) ? 'd-none' : '' ?>">
                <label for="densidad_mp" class="col-4 text-center py-1"><strong>Densidad</strong></label>
                <div class="col-4 bg-blue py-1 px-3"><?= $calidadMPrima['densidadMPrima'] . ' ( &plusmn; 0.1 )' ?></div>
                <div class="col-4">
                    <input type="text" class="form-control" name="densidad_mp" id="densidad_mp" onkeydown="return aceptaNum(event)" value="<?= $calidadMPrima['densidad_mp'] ?>">
                </div>
            </div>
            <div class="mb-3 row <?= empty($calidadMPrima['olorMPrima']) ? 'd-none' : '' ?>">
                <label for="olor_mp" class="col-4 text-center py-1"><strong>Olor</strong></label>
                <div class="col-4 bg-blue py-1 px-3"><?= $calidadMPrima['olorMPrima'] ?></div>
                <div class="col-4">
                    <select name="olor_mp" id="olor_mp" class="form-select text-center">
                        <option value="1" <?= $calidadMPrima['olor_mp'] == 1 ? 'selected' : '' ?>>Si</option>
                        <option value="0" <?= $calidadMPrima['olor_mp'] == 0 ? 'selected' : '' ?>>No</option>
                    </select>
                </div>
            </div>
            <div class="mb-3 row <?= empty($calidadMPrima['colorMPrima']) ? 'd-none' : '' ?>">
                <label for="color_mp" class="col-4 text-center py-1"><strong>Color</strong></label>
                <div class="col-4 bg-blue py-1 px-3"><?= $calidadMPrima['colorMPrima'] ?></div>
                <div class="col-4">
                    <select name="color_mp" id="color_mp" class="form-select text-center">
                        <option value="1" <?= $calidadMPrima['color_mp'] == 1 ? 'selected' : '' ?>>Si</option>
                        <option value="0" <?= $calidadMPrima['color_mp'] == 0 ? 'selected' : '' ?>>No</option>
                    </select>
                </div>
            </div>
            <div class="mb-3 row <?= empty($calidadMPrima['aparienciaMPrima']) ? 'd-none' : '' ?>">
                <label for="apariencia_mp" class="col-4 text-center py-1"><strong>Apariencia</strong></label>
                <div class="col-4 bg-blue py-1 px-3"><?= $calidadMPrima['aparienciaMPrima'] ?></div>
                <div class="col-4">
                    <select name="apariencia_mp" id="apariencia_mp" class="form-select text-center">
                        <option value="1" <?= $calidadMPrima['apariencia_mp'] == 1 ? 'selected' : '' ?>>Si</option>
                        <option value="0" <?= $calidadMPrima['apariencia_mp'] == 0 ? 'selected' : '' ?>>No</option>
                    </select>
                </div>
            </div>

            <div class="mb-3 row">
                <div class="text-center col-4">
                    <label for="fecha_vencimiento" class="py-1"><strong>Fecha de vencimiento</strong></label>
                </div>

                <div class="offset-4 col-4">
                    <input class="form-control" type="date" name="fecha_vencimiento" value="<?= $calidadMPrima['fecha_vencimiento'] ?>" id="fecha_vencimiento" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="fecha_analisis" class="col-4 text-center py-1"><strong>Fecha análisis</strong></label>
                <div class="offset-4 col-4">
                    <input class="form-control" type="date" name="fecha_analisis" value="<?= $calidadMPrima['fecha_analisis'] ?>" id="fecha_analisis" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="est_mprima" class="col-4 text-center py-1"><strong>Nuevo estado</strong></label>
                <div class="offset-4 col-4">
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
                <label for="observaciones" class="col-4 text-center py-1"><strong>Observaciones</strong></label>
                <div class="col-8 ps-0">
                    <textarea class="form-control" name="observaciones" id="observaciones"><?= $calidadMPrima['observaciones'] ?></textarea>
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
</div>
</body>
</html>