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
    <title>Actualizar precio de compra de Producto de Distribución</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>ACTUALIZACIÓN DE PRECIO DE COMPRA DE <?= ($productoDistribucion['producto']) ?></h4></div>
    <form id="form1" name="form1" method="post" action="updateDisPrecio.php">
        <div class="mb-3 row">
            <div class="col-1">
                <label class="form-label " for="idDistribucion"><strong>Código</strong></label>
                <input type="text" class="form-control " name="idDistribucion" id="idDistribucion"
                       value="<?= ($productoDistribucion['idDistribucion']) ?>" readOnly>
            </div>
            <div class="col-2">
                <label class="form-label " for="precio_actual"><strong>Precio Actual</strong></label>
                <input type="text" class="form-control" name="precio_actual" id="precio_actual" value="<?= ($productoDistribucion['precioCom']) ?>"  maxlength="50">
            </div>
            <div class="col-2">
                <label class="form-label " for="precioCom"><strong>Precio nuevo</strong></label>
                <input type="text" class="form-control " name="precioCom" id="precioCom"
                       value="" onkeydown="return aceptaNum(event)">
            </div>
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
