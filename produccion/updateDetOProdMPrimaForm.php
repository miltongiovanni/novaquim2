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
$DetOProdMPrimaOperador = new DetOProdMPrimaOperaciones();
$detalle = $DetOProdMPrimaOperador->getDetOProdMPrimas($loteMP, $idMPrima);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar detalle orden de producción materia prima</title>
    <script src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor">
    <div id="saludo"><strong>ACTUALIZACIÓN DE GASTO DE MATERIA PRIMA</strong></div>
    <form action="updateDetOProdMPrima.php" method="post" name="actualiza">
        <input type="hidden" name="loteMP" id="loteMP" value="<?= $loteMP ?>">
        <input type="hidden" name="idMPrima" id="idMPrima" value="<?= $idMPrima ?>">
        <input type="hidden" name="cantidad_ant" id="cantidad_ant" value="<?= $detalle['cantMPrima'] ?>">
        <div class="form-group row">
            <label class="col-form-label col-1 text-right" for="aliasMPrima"><strong>Materia Prima</strong></label>
            <input type="text" class="form-control col-2" name="aliasMPrima" id="aliasMPrima" readonly
                   value="<?= $detalle['aliasMPrima'] ?>">
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1 text-right" for="loteMPrima"><strong>Lote MPrima</strong></label>
            <input type="text" class="form-control col-2" name="loteMPrima" id="loteMP"
                   value="<?= $detalle['loteMPrima'] ?>" readonly>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1 text-right" for="cantMPrima"><strong>Cantidad MP</strong></label>
            <input type="text" class="form-control col-2" name="cantMPrima" id="cantMPrima"
                   value="<?= $detalle['cantMPrima'] ?>"
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