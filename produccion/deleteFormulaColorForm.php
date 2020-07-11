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
<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Eliminar fórmula de solución de color</title>
    <script src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor">
    <div id="saludo"><strong>ELIMINACIÓN DE FORMULACIÓN DE SOLUCIÓN DE COLOR</strong></div>
    <form method="post" action="deleteFormulaColor.php">
        <div class="form-group row">
            <label class="col-form-label col-2" for="idFormulaColor"><strong>Fórmula de color</strong></label>
            <select name="idFormulaColor" id="idFormulaColor" class="form-control col-2" ">
            <option selected disabled value="">-----------------------------</option>
            <?php
            $FormulaColorOperador = new FormulasColorOperaciones();
            $formulas = $FormulaColorOperador->getFormulasColorEliminar();
            for ($i = 0; $i < count($formulas); $i++) {
                echo '<option value="' . $formulas[$i]["idFormulaColor"] . '">' . $formulas[$i]['nomMPrima'] . '</option>';
            }
            ?>
            </select>
        </div>
        <div class="form-group row">
    <div class="col-1 text-center">
                <button class="button" type="reset"><span>Reiniciar</span></button>
            </div>
            <div class="col-1 text-center">
                <button class="button" onclick="return Enviar(this.form)"><span>Continuar</span></button>
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
