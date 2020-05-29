<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
?>
<!DOCTYPE html>
<html lang="es">
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<head>
    <meta charset="utf-8">
    <title>Seleccionar Fórmula a Actualizar</title>
    <script src="../js/validar.js"></script>


</head>
<body>
<div id="contenedor">
    <div id="saludo"><strong>SELECCIÓN DE FÓRMULA DE COLOR A ACTUALIZAR</strong></div>
    <form id="form1" name="form1" method="post" action="detFormulaColor.php">
        <div class="form-group row">
            <label class="col-form-label col-2" for="idFormulaColor"><strong>Fórmula de color</strong></label>
            <select name="idFormulaColor" id="idFormulaColor" class="form-control col-2">
                <option selected value="">-----------------------------</option>
                <?php
                $manager = new FormulasColorOperaciones();
                $formulas = $manager->getFormulasColor();
                for ($i = 0; $i < count($formulas); $i++) : ?>
                    <option value="<?= $formulas[$i]["idFormulaColor"] ?>"><?= $formulas[$i]["nomMPrima"] ?></option>
                <?php
                endfor;
                ?>
            </select>
        </div>
        <div class="row form-group">
            <div class="col-1">
                <button class="button" onclick="return Enviar(this.form)">
                    <span>Continuar</span></button>
            </div>
        </div>
    </form>
    <div class="row form-group">
        <div class="col-1">
            <button class="button1" onclick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>
