<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idDistribucion = $_POST['idDistribucion'];
$ProductoDistribucionOperador = new ProductosDistribucionOperaciones();
$productoDistribucion = $ProductoDistribucionOperador->getProductoDistribucion($idDistribucion);
?>
<!DOCTYPE html>
<html>
<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar datos de Producto de Distribución</title>
    <script type="text/javascript" src="../js/validar.js"></script>
</head
<body>
<div id="contenedor">
    <div id="saludo"><strong>ACTUALIZACIÓN DE PRODUCTOS DE DISTRIBUCIÓN</strong></div>
    <form id="form1" name="form1" method="post" action="updateDis.php">
        <div class="form-group row">

            <label class="col-form-label col-2" for="idCatDis"><strong>Categoría</strong></label>
            <input type="hidden" class="form-control col-2" name="idCatDis" id="idCatProd"
                   value="<?= ($productoDistribucion['idCatDis']) ?>">
            <input type="text" class="form-control col-2" name="catDis" id="catDis"
                   value="<?= ($productoDistribucion['catDis']) ?>" readOnly>
            <label class="col-form-label col-1" for="codSiigo"><strong>Código Siigo</strong></label>
            <input type="text" name="codSiigo" id="codSiigo" class="form-control col-3"
                   value="<?= ($productoDistribucion['codSiigo']) ?>" readonly/>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2" style="text-align: right;" for="idDistribucion"><strong>Código</strong></label>
            <input type="text" class="form-control col-2" name="idDistribucion" id="idDistribucion"
                   value="<?= ($productoDistribucion['idDistribucion']) ?>" readOnly>
            <label class="col-form-label col-1" style="text-align: right;"
                   for="producto"><strong>Producto</strong></label>
            <input type="text" class="form-control col-3" name="producto" id="producto"
                   value="<?= ($productoDistribucion['producto']) ?>"
                   onKeyPress="return aceptaLetra(event)" maxlength="50">
        </div>
        <div class="form-group row">

            <label class="col-form-label col-2" style="text-align: right;" for="precioVta"><strong>Precio de
                    Venta</strong></label>
            <input type="text" class="form-control col-2" name="precioVta" id="precioVta"
                   value="<?= ($productoDistribucion['precioVta']) ?>" onKeyPress="return aceptaNum(event)">
            <label class="col-form-label col-1" for="codIva"><strong>Tasa IVA</strong></label>
            <?php
            $manager = new TasaIvaOperaciones();
            $tasas = $manager->getTasasIva();
            $filas = count($tasas);
            echo '<select name="codIva" id="codIva" class="form-control col-3">';
            echo '<option selected value="' . $productoDistribucion['codIva'] . '">' . $productoDistribucion['tasaIva'] . '</option>';
            for ($i = 0; $i < $filas; $i++) {
                if ($tasas[$i]["idTasaIva"] != $productoDistribucion['codIva']) {
                    echo '<option value="' . $tasas[$i]["idTasaIva"] . '">' . $tasas[$i]['tasaIva'] . '</option>';
                }
            }
            echo '</select>';
            ?>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2" style="text-align: right;" for="stockDis"><strong>Stock
                    Min</strong></label>
            <input type="number" class="form-control col-2" min="0" name="stockDis" id="stockDis" pattern="[0-9]"
                   value="<?= ($productoDistribucion['stockDis']) ?>" onkeydown="return aceptaNum(event)">
            <label class="col-form-label col-1" for="cotiza"><strong>Cotizar</strong></label>
            <?php
            if ($productoDistribucion['cotiza'] == 1) {
                echo '<select name="cotiza" id="cotiza" class="form-control col-3">
                    <option value="1" selected>No</option>
                    <option value="0">Si</option>
                </select>';
            } else {
                echo '<select name="cotiza" id="cotiza" class="form-control col-3">
                    <option value="0" selected>Si</option>
                    <option value="1">No</option>
                </select>';
            }
            ?>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1" for="cotiza"><strong>Activo</strong></label>
            <?php
            if ($productoDistribucion['activo'] == 1) {
                echo '<select name="activo" id="activo" class="form-control col-1">
                    <option value="1" selected>No</option>
                    <option value="0">Si</option>
                </select>';
            } else {
                echo '<select name="activo" id="activo" class="form-control col-1">
                    <option value="0" selected>Si</option>
                    <option value="1">No</option>
                </select>';
            }
            ?>
        </div>
        <div class="form-group row">
            <div class="col-1" style="text-align: center;">
                <button class="button" onclick="return Enviar(this.form)"><span>Continuar</span></button>
            </div>
            <div class="col-1" style="text-align: center;">
                <button class="button" type="reset"><span>Reiniciar</span></button>
            </div>
        </div>
    </form>
</div>
</body>
</html>
