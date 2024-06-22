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
$calProdOperador = new CalProdOperaciones();
$calProd = $calProdOperador->getCalProd($lote);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Detalle Orden de Producción</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>

</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>EDICIÓN DEL CONTROL DE CALIDAD POR PRODUCCIÓN</h4>
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
    <div class="mb-3 row titulo">Control de calidad :</div>
    <div class="tabla-50">
        <form name="form2" method="POST" class="formatoDatos5" action="updateCalProd.php">
            <input type="hidden" name="lote" size=55 value="<?= $lote ?>">
            <div class="mb-3 row">
                <div class="col-4 text-center"><strong>Propiedad</strong></div>
                <div class="col-4 text-center"><strong>Especificación</strong></div>
                <div class="col-4 text-center"><strong>Valor / Cumple</strong></div>
            </div>
            <div class="mb-3 row text-center">
                <div class="col-4 py-1"><strong>pH</strong></div>
                <div class="col-4 bg-blue py-1"><span class="me-5">Min: <?= $producto['pHmin'] ?></span>Max: <?= $producto['pHmax'] ?></div>
                <div class="col-4">
                    <input type="text" class="form-control" name="pHProd" onkeydown="return aceptaNum(event)"
                           value="<?= $calProd['pHProd'] ?>">
                </div>
            </div>
            <div class="mb-3 row text-center">
                <div class="col-4 py-1"><strong>Densidad</strong></div>
                <div class="col-4 bg-blue py-1"><span class="me-5">Min: <?= $producto['densMin'] ?></span>Max: <?= $producto['densMax'] ?></div>
                <div class="col-4">
                    <input type="text" class="form-control" name="densidadProd" onkeydown="return aceptaNum(event)" value="<?= $calProd['densidadProd'] ?>">
                </div>
            </div>
            <div class="mb-3 row text-center">
                <div class="col-4 py-1"><strong>Olor</strong></div>
                <div class="col-4 bg-blue py-1"><?= $producto['fragancia'] ?></div>
                <div class="col-4">
                    <select name="olorProd" id="olorProd" class="form-select text-center">
                        <?php
                        if ($calProd['olorProd'] == 1):
                            ?>
                            <option value="1" selected>Si</option>
                            <option value="0">No</option>
                        <?php
                        else:
                            ?>
                            <option value="1">Si</option>
                            <option value="0" selected>No</option>
                        <?php
                        endif;
                        ?>
                    </select>
                </div>
            </div>
            <div class="mb-3 row text-center">
                <div class="col-4 py-1"><strong>Color</strong></div>
                <div class="col-4 bg-blue py-1"><?= $producto['color'] ?></div>
                <div class="col-4">
                    <select name="colorProd" id="colorProd" class="form-select text-center">
                        <?php
                        if ($calProd['colorProd'] == 1):
                            ?>
                            <option value="1" selected>Si</option>
                            <option value="0">No</option>
                        <?php
                        else:
                            ?>
                            <option value="1">Si</option>
                            <option value="0" selected>No</option>
                        <?php
                        endif;
                        ?>
                    </select>
                </div>
            </div>
            <div class="mb-3 row text-center">
                <div class="col-4 py-1"><strong>Apariencia</strong></div>
                <div class="col-4 bg-blue py-1"><?= $producto['apariencia'] ?></div>
                <div class="col-4">
                    <select name="aparienciaProd" id="aparienciaProd" class="form-select text-center">
                        <?php
                        if ($calProd['aparienciaProd'] == 1):
                            ?>
                            <option value="1" selected>Si</option>
                            <option value="0">No</option>
                        <?php
                        else:
                            ?>
                            <option value="1">Si</option>
                            <option value="0" selected>No</option>
                        <?php
                        endif;
                        ?>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-4 text-center py-1"><strong>Observaciones</strong></div>
                <div class="col-8 ps-0">
                    <textarea class="form-control" name="observacionesProd"><?= $calProd['observacionesProd'] ?></textarea>
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

</div>
</body>
</html>