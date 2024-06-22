<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idDistribucion = $_POST['idDistribucion'];
$ProductoDistribucionOperador = new ProductosDistribucionOperaciones();
$productoDistribucion = $ProductoDistribucionOperador->getProductoDistribucion($idDistribucion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar datos de Producto de Distribución</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>ACTUALIZACIÓN DE PRODUCTOS DE DISTRIBUCIÓN</h4></div>
    <form id="form1" name="form1" method="post" action="updateDis.php">
        <div class="mb-3 row">
            <div class="col-1">
                <label class="form-label " for="idDistribucion"><strong>Código</strong></label>
                <input type="text" class="form-control " name="idDistribucion" id="idDistribucion"
                       value="<?= ($productoDistribucion['idDistribucion']) ?>" readOnly>
            </div>
            <div class="col-3">
                <label class="form-label " for="producto"><strong>Producto</strong></label>
                <input type="text" class="form-control" name="producto" id="producto" value="<?= ($productoDistribucion['producto']) ?>" onkeydown="return aceptaLetra(event)" maxlength="50">
            </div>
            <div class="col-2">
                <label class="form-label " for="catDis"><strong>Categoría</strong></label>
                <input type="hidden" name="idCatDis" id="idCatDis" value="<?= ($productoDistribucion['idCatDis']) ?>">
                <input type="text" class="form-control col-2" name="catDis" id="catDis" value="<?= ($productoDistribucion['catDis']) ?>" readOnly>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-1">
                <label class="form-label " for="codSiigo"><strong>Código Siigo</strong></label>
                <input type="text" name="codSiigo" id="codSiigo" class="form-control "
                       value="<?= ($productoDistribucion['codSiigo']) ?>" readonly/>
            </div>
            <div class="col-1">
                <label class="form-label " for="precioVta"><strong>Precio venta</strong></label>
                <input type="text" class="form-control " name="precioVta" id="precioVta"
                       value="<?= ($productoDistribucion['precioVta']) ?>" onkeydown="return aceptaNum(event)">
            </div>
            <div class="col-1">
                <label class="form-label " for="codIva"><strong>Iva</strong></label>
                <?php
                $manager = new TasaIvaOperaciones();
                $tasas = $manager->getTasasIva();
                $filas = count($tasas);
                echo '<select name="codIva" id="codIva" class="form-select" required>';
                echo '<option selected value="' . $productoDistribucion['codIva'] . '">' . $productoDistribucion['iva'] . '</option>';
                for ($i = 0; $i < $filas; $i++) {
                    if ($tasas[$i]["idTasaIva"] != $productoDistribucion['codIva']) {
                        echo '<option value="' . $tasas[$i]["idTasaIva"] . '">' . $tasas[$i]['iva'] . '</option>';
                    }
                }
                echo '</select>';
                ?>
            </div>
            <div class="col-1">
                <label class="form-label " for="stockDis"><strong>Stock Min</strong></label>
                <input type="number" class="form-control " min="0" name="stockDis" id="stockDis" pattern="[0-9]"
                       value="<?= ($productoDistribucion['stockDis']) ?>" onkeydown="return aceptaNum(event)">
            </div>
            <div class="col-1">
                <label class="form-label " for="cotiza"><strong>Cotizar</strong></label>
                <?php
                if ($productoDistribucion['cotiza'] == 0) {
                    echo '<select name="cotiza" id="cotiza" class="form-select" required>
                    <option value="0" selected>No</option>
                    <option value="1">Si</option>
                </select>';
                } else {
                    echo '<select name="cotiza" id="cotiza" class="form-control">
                    <option value="1" selected>Si</option>
                    <option value="0">No</option>
                </select>';
                }
                ?>
            </div>
            <div class="col-1">
                <label class="form-label " for="cotiza"><strong>Activo</strong></label>
                <?php
                if ($productoDistribucion['activo'] == 0) {
                    echo '<select name="activo" id="activo" class="form-select">
                    <option value="0" selected>No</option>
                    <option value="1">Si</option>
                </select>';
                } else {
                    echo '<select name="activo" id="activo" class="form-select">
                    <option value="1" selected>Si</option>
                    <option value="0">No</option>
                </select>';
                }
                ?>
            </div>
        </div>
        <div class="mb-3 row">
        </div>
        <div class="mb-3 row">
        </div>
        <div class="mb-3 row">
        </div>
        <div class="mb-3 row">
            <div class="col-1 text-center">
                <button class="button" type="button" onclick="return Enviar(this.form)"><span>Continuar</span></button>
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
