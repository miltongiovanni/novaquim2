<?php
include "../includes/valAcc.php";
if (isset($_POST['lote'])) {
    $lote = $_POST['lote'];
} else {
    if (isset($_SESSION['lote'])) {
        $lote = $_SESSION['lote'];
    }
}
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
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
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>

</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1"><h4>CONTROL DE CALIDAD POR PRODUCCIÓN</h4></div>
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
    <div class="form-group row titulo">Detalle control de calidad :</div>

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
        <div class="form-control col-1 mx-2"><?= $calProd['pHProd'] ?></div>
    </div>
    <div class="form-group row">
        <div class="col-1 text-center col-form-label"><strong>Densidad</strong></div>
        <div class="col-1 bg-blue text-center col-form-label">Min: <?= $producto['densMin'] ?></div>
        <div class="col-1 bg-blue text-center col-form-label">Max: <?= $producto['densMax'] ?></div>
        <div class="form-control col-1 mx-2"><?= $calProd['densidadProd'] ?></div>
    </div>
    <div class="form-group row">
        <div class="col-1 text-center col-form-label"><strong>Olor</strong></div>
        <div class="col-2 bg-blue text-center col-form-label"><?= $producto['fragancia'] ?></div>
        <div class="form-control col-1 mx-2"><?= $calProd['olorProd'] == 1 ? "CUMPLE" : "NO CUMPLE" ?></div>
    </div>
    <div class="form-group row">
        <div class="col-1 text-center col-form-label"><strong>Color</strong></div>
        <div class="col-2 bg-blue text-center col-form-label"><?= $producto['color'] ?></div>
        <div class="form-control col-1 mx-2"><?= $calProd['colorProd'] == 1 ? "CUMPLE" : "NO CUMPLE" ?></div>
    </div>
    <div class="form-group row">
        <div class="col-1 text-center col-form-label"><strong>Apariencia</strong></div>
        <div class="col-2 bg-blue text-center col-form-label"><?= $producto['apariencia'] ?></div>
        <div class="form-control col-1 mx-2"><?= $calProd['aparienciaProd'] == 1 ? "CUMPLE" : "NO CUMPLE" ?></div>
    </div>
    <div class="form-group row mb-3">
        <div class="col-1 text-center col-form-label"><strong>Observaciones</strong></div>
        <textarea class="form-control col-3 mx-2"
                  name="observacionesProd"><?= $calProd['observacionesProd'] ?></textarea>
    </div>
    <div class="form-group row">
        <div class="col-8">
            <div class="form-group row justify-content-around">
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
            <button class="button" onClick="window.location='../menu.php'"><span>Ir al Menú</span></button>
        </div>
    </div>
</body>
</html>