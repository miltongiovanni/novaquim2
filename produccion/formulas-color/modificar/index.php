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
    <meta charset="utf-8">
    <title>Seleccionar Fórmula a Actualizar</title>
<script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">


</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>SELECCIÓN DE FÓRMULA DE COLOR A ACTUALIZAR</h4></div>
    <form id="form1" name="form1" method="post" action="../detalle/">
        <div class="mb-3 row">
            <div class="col-2">
                <label class="form-label" for="idFormulaColor"><strong>Fórmula de color</strong></label>
                <select name="idFormulaColor" id="idFormulaColor" class="form-select" required>
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
        </div>
        <div class="row mb-3">
            <div class="col-1">
                <button class="button" type="button" onclick="return Enviar(this.form)">
                    <span>Continuar</span></button>
            </div>
        </div>
    </form>
    <div class="row mb-3">
        <div class="col-1">
            <button class="button1" onclick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>
