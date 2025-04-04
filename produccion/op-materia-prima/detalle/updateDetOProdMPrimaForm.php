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
$DetOProdMPrimaOperador = new DetOProdMPrimaOperaciones();
$detalle = $DetOProdMPrimaOperador->getDetOProdMPrimas($loteMP, $idMPrima);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar detalle orden de producción materia prima</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>ACTUALIZACIÓN DE GASTO DE MATERIA PRIMA</h4></div>
    <form action="updateDetOProdMPrima.php" method="post" name="actualiza">
        <input type="hidden" name="loteMP" id="loteMP" value="<?= $loteMP ?>">
        <input type="hidden" name="idMPrima" id="idMPrima" value="<?= $idMPrima ?>">
        <input type="hidden" name="cantidad_ant" id="cantidad_ant" value="<?= $detalle['cantMPrima'] ?>">
        <div class="mb-3 row">
            <div class="col-2">
                <label class="form-label" for="aliasMPrima"><strong>Materia Prima</strong></label>
                <input type="text" class="form-control" name="aliasMPrima" id="aliasMPrima" readonly
                       value="<?= $detalle['aliasMPrima'] ?>">
            </div>
            <div class="col-2">
                <label class="form-label" for="loteMPrima"><strong>Lote MPrima</strong></label>
                <input type="text" class="form-control" name="loteMPrima" id="loteMP"
                       value="<?= $detalle['loteMPrima'] ?>" readonly>
            </div>
            <div class="col-2">
                <label class="form-label" for="cantMPrima"><strong>Cantidad MP</strong></label>
                <input type="text" class="form-control" name="cantMPrima" id="cantMPrima"
                       value="<?= $detalle['cantMPrima'] ?>"
                       onkeydown="return aceptaNum(event)">
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
