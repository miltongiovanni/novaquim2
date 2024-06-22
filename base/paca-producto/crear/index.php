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
    <title>Relación de Pacas de Productos de Distribución</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>RELACIÓN DE PACAS DE PRODUCTOS DE DISTRIBUCIÓN</h4></div>
    <form method="post" action="makeDes.php" name="form1">
        <div class="mb-3 row">
            <div class="col-3">
                <label class="form-label " for="codPaca"><strong>Producto empacado</strong></label>
                <select name="codPaca" id="codPaca" class="form-select" required>
                    <option selected disabled value="">-----------------------------</option>
                    <?php
                    $ProductoDistribucionOperador = new ProductosDistribucionOperaciones();
                    $productos = $ProductoDistribucionOperador->getProductosDistribucion(true);
                    $filas = count($productos);
                    for ($i = 0; $i < $filas; $i++) {
                        echo '<option value="' . $productos[$i]["idDistribucion"] . '">' . $productos[$i]['producto'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-3">
                <label class="form-label " for="codUnidad"><strong>Producto por unidad</strong></label>
                <select name="codUnidad" id="codUnidad" class="form-select" required>
                    <option selected disabled value="">-----------------------------</option>
                    <?php
                    $ProductoDistribucionOperador = new ProductosDistribucionOperaciones();
                    $productos = $ProductoDistribucionOperador->getProductosDistribucion(true);
                    $filas = count($productos);
                    for ($i = 0; $i < $filas; $i++) {
                        echo '<option value="' . $productos[$i]["idDistribucion"] . '">' . $productos[$i]['producto'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-2">
                <label class="form-label " for="cantidad"><strong>Unidades por empaque</strong></label>
                <input type="text" class="form-control " name="cantidad" id="cantidad" onkeydown="return aceptaNum(event)" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-1">
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
	   