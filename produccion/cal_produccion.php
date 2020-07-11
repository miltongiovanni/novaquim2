<?php
include "../includes/valAcc.php";
$lote = $_POST['lote'];
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$OProdOperador = new OProdOperaciones();
$ProdOperador = new ProductosOperaciones();
$ordenProd = $OProdOperador->getOProd($lote);
$producto = $ProdOperador->getProducto($ordenProd['codProducto']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Control de calidad orden de producción</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../js/validar.js"></script>

</head>
<body>
<div id="contenedor">
    <div id="saludo1"><strong>CONTROL DE CALIDAD POR ORDEN DE PRODUCCIÓN</strong></div>
    <div class="form-group row">
        <div class="col-1 text-right"><strong>Lote</strong></div>
        <div class="col-1 bg-blue"><?= $lote; ?></div>
        <div class="col-3 text-right"><strong>Cantidad</strong></div>
        <div class="col-1 bg-blue"><?= $ordenProd['cantidadKg'] ?> Kg</div>
        <div class="col-1 text-right"><strong>Estado</strong></div>
        <div class="col-1 bg-blue"><?= $ordenProd['descEstado'] ?></div>
    </div>
    <div class="form-group row">
        <div class="col-1 text-right"><strong>Producto</strong></div>
        <div class="col-3 bg-blue"><?= $ordenProd['nomProducto'] ?></div>
        <div class="col-2 text-right"><strong>Fecha de producción</strong></strong></div>
        <div class="col-2 bg-blue"><?= $ordenProd['fechProd'] ?></div>
    </div>
    <div class="form-group row">
        <div class="col-1 text-right"><strong>Fórmula</strong></div>
        <div class="col-3 bg-blue"><?= $ordenProd['nomFormula'] ?></div>
        <div class="col-2 text-right"><strong>Responsable</strong></div>
        <div class="col-2 bg-blue"><?= $ordenProd['nomPersonal'] ?></div>
    </div>
    <div class="form-group row titulo">Control de calidad :</div>

    <form name="form2" method="POST" action="makeCalProd.php">
        <input type="hidden" name="lote" size=55 value="<?= $lote ?>">
        <div class="form-group row">
            <div class="col-1 text-center"><strong>Propiedad</strong></div>
            <div class="col-2 text-center"><strong>Especificación</strong></div>
            <div class="col-1 text-center"><strong>Valor / Cumple</strong></div>
        </div>
        <div class="form-group row">
            <div class="col-1 text-center col-form-label"><strong>pH</strong></div>
            <div class="col-1 bg-blue text-center col-form-label">Min: <?= $producto['pHmin'] ?></div>
            <div class="col-1 bg-blue text-center col-form-label">Max: <?= $producto['pHmax'] ?></div>
            <input type="text" class="form-control col-1 mx-2" name="pHProd" onKeyPress="return aceptaNum(event)">
        </div>
        <div class="form-group row">
            <div class="col-1 text-center col-form-label"><strong>Densidad</strong></div>
            <div class="col-1 bg-blue text-center col-form-label">Min: <?= $producto['densMin'] ?></div>
            <div class="col-1 bg-blue text-center col-form-label">Max: <?= $producto['densMax'] ?></div>
            <input type="text" class="form-control col-1 mx-2" name="densidadProd" onKeyPress="return aceptaNum(event)">
        </div>
        <div class="form-group row">
            <div class="col-1 text-center col-form-label"><strong>Olor</strong></div>
            <div class="col-2 bg-blue text-center col-form-label"><?= $producto['fragancia'] ?></div>
            <select name="olorProd" id="olorProd" class="form-control col-1 mx-2">
                <option value="1" selected>Si</option>
                <option value="0">No</option>
            </select>
        </div>
        <div class="form-group row">
            <div class="col-1 text-center col-form-label"><strong>Color</strong></div>
            <div class="col-2 bg-blue text-center col-form-label"><?= $producto['color'] ?></div>
            <select name="colorProd" id="colorProd" class="form-control col-1 mx-2">
                <option value="1" selected>Si</option>
                <option value="0">No</option>
            </select>
        </div>
        <div class="form-group row">
            <div class="col-1 text-center col-form-label"><strong>Apariencia</strong></div>
            <div class="col-2 bg-blue text-center col-form-label"><?= $producto['apariencia'] ?></div>
            <select name="aparienciaProd" id="aparienciaProd" class="form-control col-1 mx-2">
                <option value="1" selected>Si</option>
                <option value="0">No</option>
            </select>
        </div>
        <div class="form-group row">
            <div class="col-1 text-center col-form-label"><strong>Observaciones</strong></div>
            <textarea class="form-control col-3 mx-2" name="observacionesProd"></textarea>
        </div>
        <div class="form-group row">
    <div class="col-1 text-center">
                <button class="button" type="reset"><span>Reiniciar</span></button>
            </div>
            <div class="col-1 text-center">
                <button class="button" onclick="return Enviar(this.form)"><span>Continuar</span></button>
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