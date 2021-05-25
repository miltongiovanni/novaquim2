<?php
include "../includes/valAcc.php";
$idCotPersonalizada = $_POST['idCotPersonalizada'];
$codProducto = $_POST['codProducto'];

function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$DetCotizacionOperador = new DetCotizacionPersonalizadaOperaciones();
$detalle = $DetCotizacionOperador->getDetProdCotizacion($idCotPersonalizada, $codProducto);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar Cotización Personalizada</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>

</head>
<body>
<div id="contenedor">
    <div id="saludo"><h4>ACTUALIZACIÓN DEL PRODUCTO EN LA COTIZACIÓN</h4></div>
    <form action="updateCotP.php" method="post" name="actualiza">
        <input name="idCotPersonalizada" type="hidden" value="<?= $idCotPersonalizada; ?>">
        <input name="codProducto" type="hidden" value="<?= $codProducto; ?>">
        <div class="row">
            <label class="col-form-label col-4 text-center mx-2" for="producto"><strong>Producto</strong></label>
            <label class="col-form-label col-1 text-center mx-2" for="canProducto"><strong>Cantidad</strong></label>
            <label class="col-form-label col-1 text-center mx-2" for="precioProducto"><strong>Precio</strong></label>
        </div>
        <div class="form-group row">
            <input type="text" class="form-control col-4 mx-2" name="producto" readonly
                   id="producto" value="<?= $detalle['producto'] ?>">
            <input type="text" class="form-control col-1 mx-2" name="canProducto"
                   id="canProducto" onkeydown="return aceptaNum(event)" value="<?= $detalle['canProducto'] ?>">
            <input type="text" class="form-control col-1 mx-2" name="precioProducto" id="precioProducto"
                   onkeydown="return aceptaNum(event)" value="<?= $detalle['precioProducto'] ?>">
        </div>
        <div class="form-group row">
            <div class="col-2 text-center" style="padding: 0 20px;">
                <button class="button" type="button" onclick="return Enviar(this.form)"><span>Actualizar detalle</span>
                </button>
            </div>
        </div>
    </form>
</div>
</body>
</html>
