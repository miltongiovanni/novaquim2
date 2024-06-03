<?php
include "../../../includes/valAcc.php";

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$codMPrima = $_POST['codMPrima'];
$MPrimaOperador = new MPrimasOperaciones();
$mprima = $MPrimaOperador->getMPrima($codMPrima);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar datos de Materia Prima</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>

<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>ACTUALIZACIÓN DE MATERIA PRIMA</h4></div>
    <form id="form1" name="form1" method="post" action="updateMP.php">
        <div class="mb-3 row">
            <div class="col-3">
                <label class="form-label " for="idCatMPrima"><strong>Categoría MP</strong></label>
                <input type="hidden" name="idCatMPrima" id="idCatMPrima" value="<?= $mprima['idCatMPrima']; ?>" readOnly>
                <input type="text" class="form-control " name="catMP" id="catMP" value="<?= $mprima['catMP']; ?>" readOnly>
            </div>
            <div class="col-1">
                <label class="form-label " for="codMPrima"><strong>Código</strong></label>
                <input type="text" class="form-control " name="codMPrima" id="codMPrima" readOnly value="<?= $mprima['codMPrima']; ?>">
            </div>
            <div class="col-2">
                <label class="form-label " for="aliasMPrima"><strong>Alias M Prima</strong></label>
                <input type="text" class="form-control " name="aliasMPrima" id="aliasMPrima" readOnly
                       value="<?= $mprima['aliasMPrima']; ?>">
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-3">
                <label class="form-label " for="nomMPrima"><strong>Materia Prima</strong></label>
                <input type="text" class="form-control " name="nomMPrima" id="nomMPrima"
                       value="<?= $mprima['nomMPrima']; ?>">
            </div>
            <div class="col-3">
                <label class="form-label " for="aparienciaMPrima"><strong>Apariencia</strong></label>
                <input type="text" class="form-control " name="aparienciaMPrima" id="aparienciaMPrima"
                       onkeydown="return aceptaLetra(event)" value="<?= $mprima['aparienciaMPrima']; ?>">
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-1">
                <label class="form-label " for="codIva"><strong>Iva</strong></label>
            <?php
            $manager = new TasaIvaOperaciones();
            $tasas = $manager->getTasasIva();
            $filas = count($tasas);
            echo '<select name="codIva" id="codIva" class="form-control " required>';
            echo '<option selected value="' . $mprima['codIva'] . '">' . $mprima['iva'] . '</option>';
            for ($i = 0; $i < $filas; $i++) {
                if ($mprima['codIva'] != $tasas[$i]["idTasaIva"])
                    echo '<option value="' . $tasas[$i]["idTasaIva"] . '">' . $tasas[$i]['iva'] . '</option>';
            }
            echo '</select></div>';
            ?>
            <div class="col-1">
                <label class="form-label " for="minStockMprima"><strong>Stock Min</strong></label>
                <input type="text" class="form-control " name="minStockMprima" id="minStockMprima"
                       onkeydown="return aceptaNum(event)" value="<?= $mprima['minStockMprima']; ?>">
            </div>
                <div class="col-2">
                    <label class="form-label " for="pHmPrima"><strong>pH</strong></label>
                    <input type="text" class="form-control " name="pHmPrima" id="pHmPrima"
                           value="<?= $mprima['pHmPrima']; ?>">
                </div>
                <div class="col-2">
                    <label class="form-label " for="densidadMPrima"><strong>Densidad</strong></label>
                    <input type="text" class="form-control " name="densidadMPrima" id="densidadMPrima"
                           placeholder="Si no tiene escribir N.A." value="<?= $mprima['densidadMPrima']; ?>">
                </div>
        </div>
        <div class="mb-3 row">
            <div class="col-3">
                <label class="form-label " for="colorMPrima"><strong>Color</strong></label>
                <input type="text" class="form-control " name="colorMPrima" id="colorMPrima"
                       onkeydown="return aceptaLetra(event)" maxlength="30" value="<?= $mprima['colorMPrima']; ?>">
            </div>
            <div class="col-3">
                <label class="form-label " for="olorMPrima"><strong>Olor</strong></label>
                <input type="text" class="form-control " name="olorMPrima" id="olorMPrima"
                       onkeydown="return aceptaLetra(event)" maxlength="30" value="<?= $mprima['olorMPrima']; ?>">
            </div>
        </div>
        <div class="mb-3 row">
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