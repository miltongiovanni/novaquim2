<?php
include "../includes/valAcc.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
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

switch ($tipoCompra) {
    case 1:
        $titulo = ' materias primas';
        break;
    case 2:
        $titulo = ' envases y/o tapas';
        break;
    case 3:
        $titulo = ' etiquetas';
        break;
    case 5:
        $titulo = ' productos de distribución';
        break;
}

$DetCompraOperador = new DetComprasOperaciones();
$detalle = $DetCompraOperador->getDetCompra($idCompra, $tipoCompra, $codigo);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar compra de<?= $titulo ?></title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor">
    <div id="saludo"><strong>ACTUALIZACIÓN DE LA COMPRA DE<?= $titulo ?></strong></div>
    <form action="updateDetCompra.php" method="post" name="actualiza">
        <input type="hidden" name="idCompra" id="idCompra" value="<?= $idCompra ?>">
        <input type="hidden" name="tipoCompra" id="tipoCompra" value="<?= $tipoCompra ?>">
        <input type="hidden" name="codigo" id="codigo" value="<?= $codigo ?>">

        <div class="form-group row">
            <label class="col-form-label col-1 text-right" for="Producto"><strong>Producto</strong></label>
            <input type="text" class="form-control col-2" name="Producto" id="Producto" readonly
                   value="<?= $detalle['Producto'] ?>">
        </div>
        <?php
        if ($tipoCompra == 1) {
            $InvMPrimasOperador = new InvMPrimasOperaciones();
            $fechLote = $InvMPrimasOperador->getFechaLoteInvMPrima($codigo, $detalle['lote']);
            ?>
            <div class="form-group row">
                <label class="col-form-label col-1 text-right" for="lote"><strong>Lote</strong></label>
                <input type="text" class="form-control col-2" name="lote" id="lote"
                       value="<?= $detalle['lote'] ?>">
            </div>
            <div class="form-group row">
                <label class="col-form-label col-1 text-right" for="fechLote"><strong>Fecha lote</strong></label>
                <input type="text" class="form-control col-2" name="fechLote" id="fechLote"
                       value="<?= $fechLote ?>">
            </div>
            <?php
        }
        ?>
        <div class="form-group row">
            <label class="col-form-label col-1 text-right" for="cantidad"><strong>Cantidad</strong></label>
            <input type="text" class="form-control col-2" name="cantidad" id="cantidad"
                   value="<?= $detalle['cantidad'] ?>" onKeyPress="return aceptaNum(event)">
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1 text-right" for="precio"><strong>Precio</strong></label>
            <input type="text" class="form-control col-2" name="precio" id="precio" value="<?= $detalle['precio'] ?>"
                   onKeyPress="return aceptaNum(event)">

        </div>
        <div class="form-group row">
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
