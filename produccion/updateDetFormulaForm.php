<?php
include "../includes/valAcc.php";
$idFormula = $_POST['idFormula'];
$codMPrima = $_POST['codMPrima'];

function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$DetFormulaOperador = new DetFormulaOperaciones();
$detalle = $DetFormulaOperador->getDetFormula($idFormula, $codMPrima);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar datos de Presentación de Producto</title>
    <script src="../js/validar.js"></script>

</head>
<body>
<div id="contenedor">
    <div id="saludo"><strong>ACTUALIZACIÓN DE FORMULACIÓN</strong></div>
    <form action="updateDetFormula.php" method="post" name="actualiza">
        <input name="idFormula" type="hidden" value="<?= $idFormula; ?>">
        <input name="codMPrima" type="hidden" value="<?= $codMPrima; ?>">
        <div class="row">
            <label class="col-form-label col-3 text-center" for="codMPrima" style="margin: 0 5px 0 0;"><strong>Materia
                    Prima</strong></label>
            <label class="col-form-label col-1 text-center" for="porcentaje" style="margin: 0 5px;"><strong>% en
                    fórmula</strong></label>
            <label class="col-form-label col-1 text-center" for="orden"
                   style="margin: 0 5px;"><strong>Orden</strong></label>
        </div>
        <div class="form-group row">
            <input type="text" style="margin: 0 5px;" class="form-control col-3" name="porcentaje" readonly
                   id="porcentaje" onKeyPress="return aceptaNum(event)" value="<?= $detalle['nomMPrima'] ?>">
            <input type="text" style="margin: 0 5px;" class="form-control col-1" name="porcentaje"
                   id="porcentaje" onKeyPress="return aceptaNum(event)" value="<?= $detalle['porcentaje'] * 100 ?>">
            <input type="text" style="margin: 0 5px;" class="form-control col-1" name="orden" id="orden"
                   onKeyPress="return aceptaNum(event)" value="<?= $detalle['orden'] ?>">
        </div>
        <div class="form-group row">
            <div class="col-2 text-center" style="padding: 0 20px;">
                <button class="button" onclick="return Enviar(this.form)"><span>Actualizar detalle</span></button>
            </div>
        </div>
    </form>
</div>
</body>
</html>