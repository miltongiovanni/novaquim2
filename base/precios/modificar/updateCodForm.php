<?php
include "../../../includes/valAcc.php";

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$codigoGen = $_POST['codigoGen'];
$PrecioOperador = new PreciosOperaciones();
$precio = $PrecioOperador->getPrecio($codigoGen);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar datos de Código Genérico</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>

</head>

<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>ACTUALIZACIÓN DEL CÓDIGO GENÉRICO</h4></div>

    <form id="form1" name="form1" method="post" action="updateCod.php">
        <div class="form-group row">
            <div class="col-1 text-end">
                <label class="col-form-label " for="codigoGen"><strong>Código</strong></label>
            </div>
            <div class="col-3 px-0">
                <input type="text" class="form-control " name="codigoGen" id="codigoGen" maxlength="50"
                       value="<?= $precio['codigoGen']; ?>" readonly>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-1 text-end">
                <label class="col-form-label " for="producto"><strong>Descripción</strong></label>
            </div>
            <div class="col-3 px-0">
                <input type="text" class="form-control " name="producto" id="producto" maxlength="50" value="<?= $precio['producto']; ?>" readonly>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-1 text-end">
                <label class="col-form-label " for="fabrica"><strong>Precio fábrica</strong></label>
            </div>
            <div class="col-3 px-0">
                <input type="text" class="form-control " name="fabrica" id="fabrica" maxlength="50"
                       value="<?= $precio['fabrica']; ?>" onkeydown="return aceptaNum(event)">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-1 text-end">
                <label class="col-form-label " for="presActiva"><strong>Activo</strong></label>
            </div>
            <div class="col-3 px-0">
                <?php
                if ($precio['presActiva'] == 1) {
                    echo '<select name="presActiva" class="form-control " id="presActiva">';
                    echo '<option selected value=1>Si</option>';
                    echo '<option value=0>No </option>';
                    echo '</select>';
                } else {
                    echo '<select name="presActiva" class="form-control "  id="presActiva">';
                    echo '<option selected value=0>No</option>';
                    echo '<option value=1>Si</option>';
                    echo '</select>';
                }
                ?>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-1 text-end">
                <label class="col-form-label " for="presLista"><strong>En lista</strong></label>
            </div>
            <div class="col-3 px-0">
            <?php
            if ($precio['presLista'] == 1) {
                echo '<select name="presLista" class="form-control " id="presLista">';
                echo '<option selected value=1>Si</option>';
                echo '<option value=0>No </option>';
                echo '</select>';
            } else {
                echo '<select name="presLista" class="form-control "  id="presLista">';
                echo '<option selected value=0>No</option>';
                echo '<option value=1>Si</option>';
                echo '</select>';
            }
            ?>
            </div>
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