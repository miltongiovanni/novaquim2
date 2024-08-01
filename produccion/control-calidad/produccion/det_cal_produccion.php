<?php
include "../../../includes/valAcc.php";
if (isset($_POST['lote'])) {
    $lote = $_POST['lote'];
} else {
    if (isset($_SESSION['lote'])) {
        $lote = $_SESSION['lote'];
    }
}
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$OProdOperador = new OProdOperaciones();
$ordenProd = $OProdOperador->getOProd($lote);
$ProdOperador = new ProductosOperaciones();
$producto = $ProdOperador->getProducto($ordenProd['codProducto']);
$calProdOperador = new CalProdOperaciones();
$calProd = $calProdOperador->getCalProd($lote);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Detalle Control de Calidad de producto</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>

</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>CONTROL DE CALIDAD POR PRODUCCIÓN</h4>
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
    <div class="mb-3 row titulo">Detalle control de calidad :</div>

    <input type="hidden" name="lote" size=55 value="<?= $lote ?>">
    <div class="mb-3 row formatoDatos5">
        <div class="col-1 text-center"><strong>Propiedad</strong></div>
        <div class="col-2 text-center"><strong>Especificación</strong></div>
        <div class="col-1 text-center"><strong>Valor / Cumple</strong></div>
    </div>
    <div class="mb-3 row formatoDatos5 text-center">
        <div class="col-1"><strong>pH</strong></div>
        <div class="col-2 bg-blue"><span class="me-5">Min: <?= $producto['pHmin'] ?></span>Max: <?= $producto['pHmax'] ?></div>
        <div class="col-1"><?= $calProd['pHProd'] ?></div>
    </div>
    <div class="mb-3 row formatoDatos5 text-center">
        <div class="col-1"><strong>Densidad</strong></div>
        <div class="col-2 bg-blue"><span class="me-5">Min: <?= $producto['densMin'] ?></span>Max: <?= $producto['densMax'] ?></div>
        <div class="col-1"><?= $calProd['densidadProd'] ?></div>
    </div>
    <div class="mb-3 row formatoDatos5 text-center">
        <div class="col-1"><strong>Olor</strong></div>
        <div class="col-2 bg-blue"><?= $producto['fragancia'] ?></div>
        <div class="col-1"><?= $calProd['olorProd'] == 1 ? "CUMPLE" : "NO CUMPLE" ?></div>
    </div>
    <div class="mb-3 row formatoDatos5 text-center">
        <div class="col-1"><strong>Color</strong></div>
        <div class="col-2 bg-blue"><?= $producto['color'] ?></div>
        <div class="col-1"><?= $calProd['colorProd'] == 1 ? "CUMPLE" : "NO CUMPLE" ?></div>
    </div>
    <div class="mb-3 row formatoDatos5 text-center">
        <div class="col-1"><strong>Apariencia</strong></div>
        <div class="col-2 bg-blue"><?= $producto['apariencia'] ?></div>
        <div class="col-1"><?= $calProd['aparienciaProd'] == 1 ? "CUMPLE" : "NO CUMPLE" ?></div>
    </div>
    <div class="mb-3 row formatoDatos5 text-center">
        <div class="col-1"><strong>Observaciones</strong></div>
        <div class="col-3 ps-0">
            <textarea class="form-control" name="observacionesProd"><?= $calProd['observacionesProd'] ?></textarea>
        </div>
    </div>
    <div class="mb-3 row">
        <div class="col-8">
            <div class="mb-3 row justify-content-around">
                <?php if ($ordenProd['estado'] != 2) : ?>
                    <div class="col-3">
                        <form action="Imp_Cert_an.php" method="post" target="_blank">
                            <input name="lote" type="hidden" value="<?= $lote; ?>">
                            <button class="button" type="submit">
                                <span>Imprimir certificado</span>
                            </button>
                        </form>
                    </div>
                <?php
                endif;
                ?>
                <div class="col-3">
                    <form action="mod_cal_produccion.php" method="post">
                        <input name="lote" type="hidden" value="<?= $lote; ?>">
                        <button class="button" type="button" onclick="return Enviar(this.form)">
                            <span>Editar control de calidad</span>
                        </button>
                    </form>
                </div>
                <?php if ($ordenProd['estado'] != 2) : ?>
                    <div class="col-3">
                        <form action="Imp_Env_prod.php" method="post" target="_blank">
                            <input name="lote" type="hidden" value="<?php echo $lote; ?>">
                            <button class="button" type="submit">
                                <span>Imprimir orden envasado</span>
                            </button>
                        </form>
                    </div>
                <?php
                endif;
                ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-1">
            <button class="button" onClick="window.location='../../../menu.php'"><span>Ir al Menú</span></button>
        </div>
    </div>
</body>
</html>