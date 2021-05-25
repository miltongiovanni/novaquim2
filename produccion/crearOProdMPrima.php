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
    <title>Preparación de Materia Prima</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<?php
foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if (is_array($valor)) {
        //echo $nombre_campo.print_r($valor).'<br>';
    } else {
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}

?>
<div id="contenedor">
    <div id="saludo"><h4>PREPARACIÓN DE MATERIA PRIMA</h4></div>
    <form method="post" action="makeO_Prod_MP.php" name="form1">
        <div class="form-group row">
            <label class="col-form-label col-2" for="idFormulaMPrima"><strong>Materia prima</strong></label>
            <?php
            $FormulaMPrimaOperador = new FormulasMPrimaOperaciones();
            $formulas = $FormulaMPrimaOperador->getFormulasMPrima();
            $filas = count($formulas);
            echo '<select name="idFormulaMPrima" id="idFormulaMPrima" class="form-control col-2" required>';
            echo '<option selected disabled value="">-----------------------------</option>';
            for ($i = 0; $i < $filas; $i++) {
                echo '<option value="' . $formulas[$i]["idFormulaMPrima"] . '">' . $formulas[$i]['nomMPrima'] . '</option>';
            }
            echo '</select>';
            ?>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2 text-right" for="fechProd"><strong>Fecha de Producción</strong></label>
            <input type="date" class="form-control col-2" name="fechProd" id="fechProd" required>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2" for="codPersonal"><strong>Responsable</strong></label>
            <?php
            $PersonalOperador = new PersonalOperaciones();
            $personal = $PersonalOperador->getPersonalProd();
            echo '<select name="codPersonal" id="codPersonal" class="form-control col-2"  required>';
            echo '<option selected disabled value="">-----------------------------</option>';
            for ($i = 0; $i < count($personal); $i++) {
                echo '<option value="' . $personal[$i]["idPersonal"] . '">' . $personal[$i]['nomPersonal'] . '</option>';
            }
            echo '</select>';
            ?>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2 text-right" for="cantKg"><strong>Cantidad a Producir
                    (Kg)</strong></label>
            <input type="text" class="form-control col-2" name="cantKg" id="cantKg"
                   onkeydown="return aceptaNum(event)" required>
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
            <button class="button1" id="back" onClick="window.location='../menu.php'"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>