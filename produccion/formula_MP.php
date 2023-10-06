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
    <title>Ingreso de Fórmulas de Materia Prima</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>INGRESO DE FÓRMULAS DE MATERIA PRIMA</h4></div>
    <form method="post" action="makeFormulaMPrima.php" name="form1">
        <div class="form-group row">
            <label class="col-form-label col-2" for="codMPrima"><strong>Materia Prima</strong></label>
            <select name="codMPrima" id="codMPrima" class="form-select col-2" required>
                <option selected disabled value="">-----------------------------</option>
                <?php
                $FormulaMPrimaOperador = new FormulasMPrimaOperaciones();
                $soluciones = $FormulaMPrimaOperador->getMPrimasParaFormula();
                for ($i = 0; $i < count($soluciones); $i++) {
                    echo '<option value="' . $soluciones[$i]["codMPrima"] . '">' . $soluciones[$i]['nomMPrima'] . '</option>';
                }
                ?>
            </select>
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