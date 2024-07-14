<?php
include "../../../includes/valAcc.php";
$idCotPersonalizada = $_POST['idCotPersonalizada'];
$codProducto = $_POST['codProducto'];

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$DetCotizacionOperador = new DetCotizacionPersonalizadaOperaciones();
$detalle = $DetCotizacionOperador->getDetProdCotizacion($idCotPersonalizada, $codProducto);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar Cotización Personalizada</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>

</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>ACTUALIZACIÓN DEL PRODUCTO EN LA COTIZACIÓN</h4></div>
    <form action="updateCotP.php" method="post" name="actualiza">
        <input name="idCotPersonalizada" type="hidden" value="<?= $idCotPersonalizada; ?>">
        <input name="codProducto" type="hidden" value="<?= $codProducto; ?>">
        <div class="row mb-3">
            <div class="col-4">
                <label class="form-label col-4 text-center mx-2" for="producto"><strong>Producto</strong></label>
                <input type="text" class="form-control col-4 mx-2" name="producto" readonly
                       id="producto" value="<?= $detalle['producto'] ?>">
            </div>
            <div class="col-1">
                <label class="form-label col-1 text-center mx-2" for="canProducto"><strong>Cantidad</strong></label>
                <input type="text" class="form-control col-1 mx-2" name="canProducto"
                       id="canProducto" onkeydown="return aceptaNum(event)" value="<?= $detalle['canProducto'] ?>">
            </div>
            <div class="col-1">
                <label class="form-label col-1 text-center mx-2" for="precioProducto"><strong>Precio</strong></label>
                <input type="text" class="form-control col-1 mx-2" name="precioProducto" id="precioProducto"
                       onkeydown="return aceptaNum(event)" value="<?= $detalle['precioProducto'] ?>">
            </div>
            <div class="col-2 pt-2">
                <button class="button mt-4" type="button" onclick="return Enviar(this.form)"><span>Actualizar detalle</span>
                </button>
            </div>
        </div>
        <div class="mb-3 row">
        </div>
    </form>
</div>
</body>
</html>
