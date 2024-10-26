<?php
include "../../../includes/valAcc.php";
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
$EnvasadoOperador = new EnvasadoOperaciones();
$presentacion = $EnvasadoOperador->getEnvasado($lote, $codPresentacion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar datos de Envasado por Lote de Producto</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>

</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>ACTUALIZACIÓN DE ENVASADO POR PRESENTACIÓN</h4></div>
    <form action="updateEnvasado.php" method="post" name="actualiza">
        <input type="hidden" name="lote" id="lote" value="<?= $lote ?>">
        <input type="hidden" name="cantidadPendiente" id="cantidadPendiente" value="<?= $cantidadPendiente ?>">
        <input type="hidden" name="codPresentacion" id="codPresentacion" value="<?= $codPresentacion ?>">
        <input type="hidden" name="cantidad_ant" id="cantidad_ant" value="<?= $presentacion['cantPresentacion'] ?>">
        <div class="mb-3 row">
            <div class="col-4">
                <label class="form-label" for="presentacion"><strong>Presentación de Producto</strong></label>
                <input type="text" class="form-control " name="presentacion" id="presentacion" readonly
                       value="<?= $presentacion['presentacion'] ?>">
            </div>
            <div class="col-1">
                <label class="form-label" for="cantPresentacion"><strong>Cantidad</strong></label>
                <input type="text" class="form-control" name="cantPresentacion" id="cantPresentacion"
                       value="<?= $presentacion['cantPresentacion'] ?>" onkeydown="return aceptaNum(event)">
            </div>
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
