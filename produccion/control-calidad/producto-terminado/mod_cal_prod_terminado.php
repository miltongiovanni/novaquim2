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
$ProdOperador = new ProductosOperaciones();
$ordenProd = $OProdOperador->getOProd($lote);
$producto = $ProdOperador->getProducto($ordenProd['codProducto']);
$calProdTerminadoOperador = new CalProdTerminadoOperaciones();
$calProd = $calProdTerminadoOperador->getCalProdTerminado($lote);
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
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>CONTROL DE CALIDAD PRODUCTO ENVASADO POR ORDEN DE PRODUCCIÓN</h4></div>
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
        <div class="col-1">
            <strong>Cantidad</strong>
            <div class="bg-blue"><?= $ordenProd['cantidadKg'] ?> Kg</div>
        </div>
        <div class="col-2">
            <strong>Fecha de producción</strong>
            <div class="bg-blue"><?= $ordenProd['fechProd'] ?></div>
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
        <form name="form2" class="formatoDatos5" method="POST" action="updateCalProdTerminado.php">
            <input type="hidden" name="lote" size=55 value="<?= $lote ?>">
            <div class="mb-3 row">
                <div class="col-2 text-center"><strong>Propiedad</strong></div>
                <div class="col-4 text-center"><strong>Valor / Cumple</strong></div>
            </div>
            <div class="mb-3 row">
                <div class="col-2"><strong>Etiquetado</strong></div>
                <div class="col-4">
                    <select name="etiquetado" id="etiquetado" class="form-select">
                        <option value="1" <?= $calProd['etiquetado'] == 1 ? "selected" : "" ?>>Si</option>
                        <option value="0" <?= $calProd['etiquetado'] == 0 ? "selected" : "" ?>>No</option>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-2"><strong>Envasado</strong></div>
                <div class="col-4">
                    <select name="envasado" id="envasado" class="form-select">
                        <option value="1"  <?= $calProd['envasado'] == 1 ? "selected" : "" ?>>Si</option>
                        <option value="0"  <?= $calProd['envasado'] == 0 ? "selected" : "" ?>>No</option>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-2"><strong>Observaciones</strong></div>
                <div class="col-4">
                    <textarea class="form-control" name="observaciones"><?= $calProd['observaciones'] ?></textarea>
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