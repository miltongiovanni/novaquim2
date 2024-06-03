<?php
include "../../../includes/valAcc.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if (is_array($valor)) {
        //echo $nombre_campo.print_r($valor).'<br>';
    } else {
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}


$detRemisionOperador = new DetRemisionesOperaciones();
$detalle = $detRemisionOperador->getDetTotalRemision($idRemision, $codProducto);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar detalle de la remisión</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>ACTUALIZACIÓN DEL DETALLE DE REMISIÓN</h4></div>
    <form action="updateDetRemision.php" method="post" name="actualiza">
        <input type="hidden" name="idRemision" id="idRemision" value="<?= $idRemision ?>">
        <input type="hidden" name="codProducto" id="codProducto" value="<?= $codProducto ?>">
        <div class="mb-3 row">
            <label class="form-label col-1 text-end" for="producto"><strong>Producto</strong></label>
            <input type="text" class="form-control col-4" name="producto" id="producto" readonly
                   value="<?= $detalle['producto'] ?>">
        </div>
        <div class="mb-3 row">
            <label class="form-label col-1 text-end" for="cantProducto"><strong>Cantidad</strong></label>
            <input type="text" class="form-control col-4" name="cantProducto" id="cantProducto"
                   value="<?= $detalle['cantProducto'] ?>" onkeydown="return aceptaNum(event)">
        </div>
        <div class="mb-3 row">
            <label class="form-label col-1 text-end" for="precioProducto"><strong>Precio</strong></label>
            <input type="text" class="form-control col-4" name="precioProducto" id="precioProducto"
                   value="<?= $detalle['precioProducto'] ?>" onkeydown="return aceptaNum(event)">
        </div>
        <div class="mb-3 row">
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
            <button class="button1" id="back" onClick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>
