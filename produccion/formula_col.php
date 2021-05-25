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
    <title>Ingreso de Fórmulas de Color</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor">
    <div id="saludo"><h4>INGRESO DE FÓRMULAS DE COLOR</h4></div>
    <form method="post" action="makeFormulaColor.php" name="form1">
        <div class="form-group row">
            <label class="col-form-label col-2" for="codSolucionColor"><strong>Solución de Color</strong></label>
            <select name="codSolucionColor" id="codSolucionColor" class="form-control col-2" required>
                <option selected disabled value="">-----------------------------</option>
                <?php
                $FormulaColorOperador = new FormulasColorOperaciones();
                $soluciones = $FormulaColorOperador->getSoluciones();
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