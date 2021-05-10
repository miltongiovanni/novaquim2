<?php
include "../includes/valAcc.php";
include "../includes/utilTabla.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$codMPrima = $_POST['codMPrima'];
$MPrimaOperador = new MPrimasOperaciones();
$mprima = $MPrimaOperador->getMPrima($codMPrima);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar datos de Materia Prima</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>

<body>
<div id="contenedor">
    <div id="saludo"><strong>ACTUALIZACIÓN DE MATERIA PRIMA</strong></div>
    <form id="form1" name="form1" method="post" action="updateMP.php">
        <div class="form-group row">

            <label class="col-form-label col-1" for="idCatMPrima"><strong>Categoría MP</strong></label>
            <input type="hidden" name="idCatMPrima" id="idCatMPrima" value="<?= $mprima['idCatMPrima']; ?>" readOnly>
            <input type="text" class="form-control col-2" name="catMP" id="catMP" value="<?= $mprima['catMP']; ?>"
                   readOnly>
            <label class="col-form-label col-1 text-right"
                   for="codMPrima"><strong>Código</strong></label>
            <input type="text" class="form-control col-2" name="codMPrima" id="codMPrima" readOnly
                   value="<?= $mprima['codMPrima']; ?>">
            <label class="col-form-label col-1 text-right" for="aliasMPrima"><strong>Alias M
                    Prima</strong></label>
            <input type="text" class="form-control col-2" name="aliasMPrima" id="aliasMPrima" readOnly
                   value="<?= $mprima['aliasMPrima']; ?>">

        </div>
        <div class="form-group row">
            <label class="col-form-label col-1 text-right" for="nomMPrima"><strong>Materia
                    Prima</strong></label>
            <input type="text" class="form-control col-2" name="nomMPrima" id="nomMPrima"
                   value="<?= $mprima['nomMPrima']; ?>">
            <label class="col-form-label col-1 text-right"
                   for="aparienciaMPrima"><strong>Apariencia</strong></label>
            <input type="text" class="form-control col-2" name="aparienciaMPrima" id="aparienciaMPrima"
                   onkeydown="return aceptaLetra(event)" value="<?= $mprima['aparienciaMPrima']; ?>">

        </div>
        <div class="form-group row">

            <label class="col-form-label col-1" for="codIva"><strong>Iva</strong></label>
            <?php
            $manager = new TasaIvaOperaciones();
            $tasas = $manager->getTasasIva();
            $filas = count($tasas);
            echo '<select name="codIva" id="codIva" class="form-control col-2" required>';
            echo '<option selected value="' . $mprima['codIva'] . '">' . $mprima['iva'] . '</option>';
            for ($i = 0; $i < $filas; $i++) {
                if ($mprima['codIva'] != $tasas[$i]["idTasaIva"])
                    echo '<option value="' . $tasas[$i]["idTasaIva"] . '">' . $tasas[$i]['iva'] . '</option>';
            }
            echo '</select>';
            ?>
            <label class="col-form-label col-1 text-right" for="minStockMprima"><strong>Stock
                    Min</strong></label>
            <input type="text" class="form-control col-2" name="minStockMprima" id="minStockMprima"
                   onkeydown="return aceptaNum(event)" value="<?= $mprima['minStockMprima']; ?>">
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1 text-right" for="pHmPrima"><strong>pH</strong></label>
            <input type="text" class="form-control col-2" name="pHmPrima" id="pHmPrima"
                   placeholder="Si no tiene escribir N.A." value="<?= $mprima['pHmPrima']; ?>">
            <label class="col-form-label col-1 text-right"
                   for="densidadMPrima"><strong>Densidad</strong></label>
            <input type="text" class="form-control col-2" name="densidadMPrima" id="densidadMPrima"
                   placeholder="Si no tiene escribir N.A." value="<?= $mprima['densidadMPrima']; ?>">
        </div>

        <div class="form-group row">
            <label class="col-form-label col-1 text-right"
                   for="colorMPrima"><strong>Color</strong></label>
            <input type="text" class="form-control col-2" name="colorMPrima" id="colorMPrima"
                   onkeydown="return aceptaLetra(event)" maxlength="30" value="<?= $mprima['colorMPrima']; ?>">
            <label class="col-form-label col-1 text-right"
                   for="olorMPrima"><strong>Olor</strong></label>
            <input type="text" class="form-control col-2" name="olorMPrima" id="olorMPrima"
                   onkeydown="return aceptaLetra(event)" maxlength="30" value="<?= $mprima['olorMPrima']; ?>">
        </div>
        <div class="form-group row">
            <div class="col-1 text-center">
                <button class="button" type="reset"><span>Reiniciar</span></button>
            </div>
            <div class="col-1 text-center">
                <button class="button" type="button"
                        onclick="return Enviar(this.form)"><span>Continuar</span></button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-1">
            <button class="button1" id="back" onClick="history.back()">
                <span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>

</html>