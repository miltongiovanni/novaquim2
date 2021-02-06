<?php
include "../includes/valAcc.php";
include "../includes/utilTabla.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$codigoGen = $_POST['codigoGen'];
$PrecioOperador = new PreciosOperaciones();
$precio = $PrecioOperador->getPrecio($codigoGen);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar datos de Código Genérico</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>

</head>

<body>
<div id="contenedor">
    <div id="saludo"><strong>ACTUALIZACIÓN DEL CÓDIGO GENÉRICO</strong></div>

    <form id="form1" name="form1" method="post" action="updateCod.php">
        <div class="form-group row">
            <label class="col-form-label col-1" for="codigoGen"><strong>Código</strong></label>
            <input type="text" class="form-control col-2" name="codigoGen" id="codigoGen" maxlength="50"
                   value="<?= $precio['codigoGen']; ?>" readonly>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1"
                   for="producto"><strong>Descripción</strong></label>
            <input type="text" class="form-control col-2" name="producto" id="producto" maxlength="50"
                   value="<?= $precio['producto']; ?>" readonly>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1" for="fabrica"><strong>Precio
                    fábrica</strong></label>
            <input type="text" class="form-control col-2" name="fabrica" id="fabrica" maxlength="50"
                   value="<?= $precio['fabrica']; ?>" onKeyPress="return aceptaNum(event)">
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1" for="presActiva"><strong>Activo</strong></label>
            <?php
            if ($precio['presActiva'] == 1) {
                echo '<select name="presActiva" class="form-control col-2" id="presActiva">';
                echo '<option selected value=1>Si</option>';
                echo '<option value=0>No </option>';
                echo '</select>';
            } else {
                echo '<select name="presActiva" class="form-control col-2"  id="presActiva">';
                echo '<option selected value=0>No</option>';
                echo '<option value=1>Si</option>';
                echo '</select>';
            }
            ?>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1" for="presLista"><strong>En lista</strong></label>
            <?php
            if ($precio['presLista'] == 1) {
                echo '<select name="presLista" class="form-control col-2" id="presLista">';
                echo '<option selected value=1>Si</option>';
                echo '<option value=0>No </option>';
                echo '</select>';
            } else {
                echo '<select name="presLista" class="form-control col-2"  id="presLista">';
                echo '<option selected value=0>No</option>';
                echo '<option value=1>Si</option>';
                echo '</select>';
            }
            ?>
        </div>
        <div class="form-group row">
            <div class="col-1 text-center">
                <button class="button" type="reset"><span>Reiniciar</span></button>
            </div>
            <div class="col-1 text-center">
                <button class="button" type="button"
                        onclick="return Enviar(this.form)"><span>Continuar</span></button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-1">
            <button class="button1" id="back"
                    onClick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>

</div>
</body>

</html>