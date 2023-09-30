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
    <title>Eliminar Formulación</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>ELIMINACIÓN DE FORMULACIÓN</h4></div>
    <form method="post" action="deleteFormula.php">
        <div class="form-group row">
            <label class="col-form-label col-1" for="idFormula"><strong>Fórmula</strong></label>
            <?php
            $FormulaOperador = new FormulasOperaciones();
            $formulas = $FormulaOperador->getFormulasEliminar();
            echo '<select name="idFormula" id="idFormula" class="form-select col-3" required>';
            echo '<option selected disabled value="">-----------------------------</option>';
            for ($i = 0; $i < count($formulas); $i++) {
                echo '<option value="' . $formulas[$i]["idFormula"] . '">' . $formulas[$i]['nomFormula'] . '</option>';
            }
            echo '</select>';
            ?>
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
