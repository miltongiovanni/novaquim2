<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Eliminar fórmula de solución de color</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>ELIMINACIÓN DE FORMULACIÓN DE SOLUCIÓN DE COLOR</h4></div>
    <form method="post" action="../../deleteFormulaColor.php">
        <div class="mb-3 row">
            <label class="form-label col-2" for="idFormulaColor"><strong>Fórmula de color</strong></label>
            <select name="idFormulaColor" id="idFormulaColor" class="form-select col-2" required>
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
        <div class="mb-3 row">
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
