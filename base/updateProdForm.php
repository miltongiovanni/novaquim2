<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$codProducto = $_POST['codProducto'];
$ProductoOperador = new ProductosOperaciones();
$producto = $ProductoOperador->getProducto($codProducto);
?>
<!DOCTYPE html>
<html>

<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar datos de Producto</title>
    <script  src="../js/validar.js"></script>
</head>

<body>
<div id="contenedor">
    <div id="saludo"><strong>ACTUALIZACIÓN DE PRODUCTOS</strong></div>

    <form id="form1" name="form1" method="post" action="updateProd.php">
        <div class="form-group row">

            <label class="col-form-label col-1" for="catProd"><strong>Categoría</strong></label>
            <input type="hidden" class="form-control col-2" name="idCatProd" id="idCatProd"
                   value="<?= $producto['idCatProd']; ?>">
            <input type="text" class="form-control col-2" name="catProd" id="catProd"
                   value="<?= $producto['catProd']; ?>" readOnly>
            <label class="col-form-label col-1" style="text-align: right;"
                   for="codProducto"><strong>Código</strong></label>
            <input type="text" class="form-control col-2" name="codProducto" id="codProducto"
                   value="<?= $producto['codProducto']; ?>" readOnly>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1" style="text-align: right;"
                   for="nomProducto"><strong>Producto</strong></label>
            <input type="text" class="form-control col-2" name="nomProducto" id="nomProducto"
                   onKeyPress="return aceptaLetra(event)" maxlength="50" value="<?= $producto['nomProducto']; ?>">
            <label class="col-form-label col-1" style="text-align: right;" for="apariencia"><strong>Apariencia</strong></label>
            <input type="text" class="form-control col-2" name="apariencia" id="apariencia"
                   onKeyPress="return aceptaLetra(event)" value="<?= $producto['apariencia']; ?>">
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1" style="text-align: right;" for="densMin"><strong>Densidad
                    Min</strong></label>
            <input type="text" class="form-control col-2" name="densMin" id="densMin"
                   onKeyPress="return aceptaNum(event)" value="<?= $producto['densMin']; ?>">
            <label class="col-form-label col-1" style="text-align: right;" for="densMax"><strong>Densidad
                    Max</strong></label>
            <input type="text" class="form-control col-2" name="densMax" id="densMax"
                   onKeyPress="return aceptaNum(event)" value="<?= $producto['densMax']; ?>">
        </div>

        <div class="form-group row">
            <label class="col-form-label col-1" style="text-align: right;" for="pHmin"><strong>pH Min</strong></label>
            <input type="text" class="form-control col-2" name="pHmin" id="pHmin" onKeyPress="return aceptaNum(event)"
                   value="<?= $producto['pHmin']; ?>">
            <label class="col-form-label col-1" style="text-align: right;" for="pHmax"><strong>pH Max</strong></label>
            <input type="text" class="form-control col-2" name="pHmax" id="pHmax" onKeyPress="return aceptaNum(event)"
                   value="<?= $producto['pHmax']; ?>">
        </div>

        <div class="form-group row">
            <label class="col-form-label col-1" style="text-align: right;"
                   for="fragancia"><strong>Fragancia</strong></label>
            <input type="text" class="form-control col-2" name="fragancia" id="fragancia"
                   onKeyPress="return aceptaLetra(event)" maxlength="30" value="<?= $producto['fragancia']; ?>">
            <label class="col-form-label col-1" style="text-align: right;" for="color"><strong>Color</strong></label>
            <input type="text" class="form-control col-2" name="color" id="color" onKeyPress="return aceptaLetra(event)"
                   maxlength="30" value="<?= $producto['color']; ?>">
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1" style="text-align: right;"
                   for="prodActivo"><strong>Activo</strong></label>
            <?php
            if ($producto['prodActivo'] == 1) {
                echo '<select name="prodActivo" class="form-control col-2" id="prodActivo">';
                echo '<option selected value=1>Si</option>';
                echo '<option value=0>No </option>';
                echo '</select>';
            } else {
                echo '<select name="prodActivo" class="form-control col-2"  id="prodActivo">';
                echo '<option selected value=0>No</option>';
                echo '<option value=1>Si</option>';
                echo '</select>';
            }
            ?>
        </div>
        <div class="form-group row">
            <div class="col-1" style="text-align: center;">
                <button class="button"
                        onclick="return Enviar(this.form)"><span>Continuar</span></button>
            </div>
            <div class="col-1" style="text-align: center;">
                <button class="button" type="reset"><span>Reiniciar</span></button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-1">
            <button class="button1" id="back" onClick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>

</html>