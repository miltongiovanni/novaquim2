<?php
include "../../../includes/valAcc.php";
$idFormulaColor = $_POST['idFormulaColor'];
$codMPrima = $_POST['codMPrima'];

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$DetFormulaColorOperador = new DetFormulaColorOperaciones();
$detalle = $DetFormulaColorOperador->getDetFormulaColor($idFormulaColor, $codMPrima);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar Formulación de Color</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>

</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>ACTUALIZACIÓN DE FORMULACIÓN DE COLOR</h4></div>
    <form action="updateDetFormulaColor.php" method="post" name="actualiza">
        <input name="idFormulaColor" type="hidden" value="<?= $idFormulaColor; ?>">
        <input name="codMPrima" type="hidden" value="<?= $codMPrima; ?>">
        <div class="row">
            <label class="col-form-label col-3 text-center" for="codMPrima" style="margin: 0 5px 0 0;"><strong>Materia
                    Prima</strong></label>
            <label class="col-form-label col-1 text-center" for="porcentaje" style="margin: 0 5px;"><strong>% en
                    fórmula</strong></label>
        </div>
        <div class="form-group row">
            <input type="text" style="margin: 0 5px;" class="form-control col-3" name="porcentaje" readonly
                   id="porcentaje" onkeydown="return aceptaNum(event)" value="<?= $detalle['nomMPrima'] ?>">
            <input type="text" style="margin: 0 5px;" class="form-control col-1" name="porcentaje"
                   id="porcentaje" onkeydown="return aceptaNum(event)" value="<?= $detalle['porcentaje'] * 100 ?>">
        </div>
        <div class="form-group row">
            <div class="col-2 text-center" style="padding: 0 20px;">
                <button class="button" type="button" onclick="return Enviar(this.form)"><span>Actualizar detalle</span></button>
            </div>
        </div>
    </form>
</div>
</body>
</html>
