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
    <meta charset="utf-8">
    <title>Seleccionar Fórmula a Actualizar</title>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2"><h4>SELECCIÓN DE FÓRMULA DE MATERIA PRIMA A ACTUALIZAR</h4></div>
    <form id="form1" name="form1" method="post" action="detFormulaMPrima.php">
        <div class="form-group row">
            <label class="col-form-label col-2" for="idFormulaMPrima"><strong>Fórmula de Materia Prima</strong></label>
            <select name="idFormulaMPrima" id="idFormulaMPrima" class="form-control col-2" required>
                <option selected value="">-----------------------------</option>
                <?php
                $manager = new FormulasMPrimaOperaciones();
                $formulas = $manager->getFormulasMPrima();
                for ($i = 0; $i < count($formulas); $i++) : ?>
                    <option value="<?= $formulas[$i]["idFormulaMPrima"] ?>"><?= $formulas[$i]["nomMPrima"] ?></option>
                <?php
                endfor;
                ?>
            </select>
        </div>
        <div class="row form-group">
            <div class="col-1">
                <button class="button" type="button" onclick="return Enviar(this.form)">
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
