<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

foreach ($_POST as $nombre_campo => $valor) {
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
    //echo $nombre_campo . " = " . $valor . "<br>";
    eval($asignacion);
}
$EnvasadoOperador = new EnvasadoOperaciones();
$presentacion = $EnvasadoOperador->getEnvasado($lote, $codPresentacion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar datos de Envasado por Lote de Producto</title>
    <script src="../js/validar.js"></script>

</head>
<body>
<div id="contenedor">
    <div id="saludo"><strong>ACTUALIZACIÓN DE ENVASADO POR PRESENTACIÓN</strong></div>
    <form action="updateEnvasado.php" method="post" name="actualiza">
        <input type="hidden" name="lote" id="lote" value="<?= $lote ?>">
        <input type="hidden" name="cantidadPendiente" id="cantidadPendiente" value="<?= $cantidadPendiente ?>">
        <input type="hidden" name="codPresentacion" id="codPresentacion" value="<?= $codPresentacion ?>">
        <input type="hidden" name="cantidad_ant" id="cantidad_ant" value="<?= $presentacion['cantPresentacion'] ?>">
        <div class="form-group row">
            <label class="col-form-label col-2 text-right" for="presentacion"><strong>Presentación de
                    Producto</strong></label>
            <input type="text" class="form-control col-3" name="presentacion" id="presentacion" readonly
                   value="<?= $presentacion['presentacion'] ?>">
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2 text-right" for="cantPresentacion"><strong>Cantidad</strong></label>
            <input type="text" class="form-control col-3" name="cantPresentacion" id="cantPresentacion"
                   value="<?= $presentacion['cantPresentacion'] ?>"
                   onKeyPress="return aceptaNum(event)">
        </div>
        <div class="form-group row">
            <div class="col-1 text-center">
                <button class="button" onclick="return Enviar(this.form)"><span>Continuar</span></button>
            </div>
            <div class="col-1 text-center">
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