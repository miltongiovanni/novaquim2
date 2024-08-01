<?php
include "../../../includes/valAcc.php";
$lote = $_POST['lote'];
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
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
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>

</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>CONTROL DE CALIDAD POR ORDEN DE PRODUCCIÓN</h4>
    </div>
    <div class="mb-3 row formatoDatos5">
        <div class="col-4">
            <strong>Producto</strong>
            <div class="bg-blue"><?= $ordenProd['nomProducto'] ?></div>
        </div>
        <div class="col-4">
            <strong>Fórmula</strong>
            <div class="bg-blue"><?= $ordenProd['nomFormula'] ?></div>
        </div>
    </div>
    <div class="mb-3 row formatoDatos5">
        <div class="col-1">
            <strong>Lote</strong>
            <div class="bg-blue"><?= $lote; ?></div>
        </div>
        <div class="col-2">
            <strong>Fecha de producción</strong>
            <div class="bg-blue"><?= $ordenProd['fechProd'] ?></div>
        </div>
        <div class="col-1">
            <strong>Cantidad</strong>
            <div class="bg-blue"><?= $ordenProd['cantidadKg'] ?> Kg</div>
        </div>
        <div class="col-2">
            <strong>Responsable</strong>
            <div class="bg-blue"><?= $ordenProd['nomPersonal'] ?></div>
        </div>
        <div class="col-2">
            <strong>Estado</strong>
            <div class="bg-blue"><?= $ordenProd['descEstado'] ?></div>
        </div>
    </div>
    <div class="mb-3 row">
    </div>
    <div class="mb-3 row titulo">Control de calidad :</div>
    <div class="tabla-50">
        <form name="form2" class="formatoDatos5" method="POST" action="makeCalProd.php">
            <input type="hidden" name="lote" size=55 value="<?= $lote ?>">
            <div class="mb-3 row">
                <div class="col-4 text-center"><strong>Propiedad</strong></div>
                <div class="col-4 text-center"><strong>Especificación</strong></div>
                <div class="col-4 text-center"><strong>Valor / Cumple</strong></div>
            </div>
            <div class="mb-3 row text-center">
                <div class="col-4 text-center py-1"><strong>pH</strong></div>
                <div class="col-4 bg-blue py-1"><span class="me-5">Min: <?= $producto['pHmin'] ?></span><span>Max: <?= $producto['pHmax'] ?></span></div>
                <div class="col-4">
                    <input type="text" class="form-control" name="pHProd" onkeydown="return aceptaNum(event)">
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-4 text-center py-1"><strong>Densidad</strong></div>
                <div class="col-4 bg-blue text-center py-1"><span class="me-5">Min: <?= $producto['densMin'] ?></span><span>Max: <?= $producto['densMax'] ?></span></div>
                <div class="col-4">
                    <input type="text" class="form-control" name="densidadProd" onkeydown="return aceptaNum(event)">
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-4 text-center py-1"><strong>Olor</strong></div>
                <div class="col-4 bg-blue text-center py-1"><?= $producto['fragancia'] ?></div>
                <div class="col-4">
                    <select name="olorProd" id="olorProd" class="form-select text-center">
                        <option value="1" selected>Si</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-4 text-center py-1"><strong>Color</strong></div>
                <div class="col-4 bg-blue text-center py-1"><?= $producto['color'] ?></div>
                <div class="col-4">
                    <select name="colorProd" id="colorProd" class="form-select text-center">
                        <option value="1" selected>Si</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-4 text-center py-1"><strong>Apariencia</strong></div>
                <div class="col-4 bg-blue text-center py-1"><?= $producto['apariencia'] ?></div>
                <div class="col-4">
                    <select name="aparienciaProd" id="aparienciaProd" class="form-select text-center">
                        <option value="1" selected>Si</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-4 text-center py-1"><strong>Observaciones</strong></div>
                <div class="col-8 ps-0">
                    <textarea class="form-control" name="observacionesProd"></textarea>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-2 text-center">
                    <button class="button" type="reset"><span>Reiniciar</span></button>
                </div>
                <div class="col-2 text-center">
                    <button class="button" type="button" onclick="return Enviar(this.form)"><span>Continuar</span></button>
                </div>
            </div>
        </form>
    </div>

    <div class="row">
        <div class="col-1">
            <button class="button1" onClick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>