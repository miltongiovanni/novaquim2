<?php
include "../../../includes/valAcc.php";
$idNotaC = $_POST['idNotaC'];
$codProducto = $_POST['codProducto'];
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$notaCrOperador = new NotasCreditoOperaciones();
$notaC = $notaCrOperador->getNotaC($idNotaC);
$detNotaCrOperador = new DetNotaCrOperaciones();
$cantidadMax = $notaCrOperador->getCantDetProductosNotaC($notaC['facturaOrigen'], $codProducto);
$detalle = $detNotaCrOperador->getDetProdNotaCr($idNotaC, $codProducto);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar datos de la Nota Crédito</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>

</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>ACTUALIZACIÓN DEL PRODUCTO EN LA NOTA CRÉDITO</h4></div>
    <form action="updateProdNota.php" method="post" name="actualiza">
        <input name="idNotaC" type="hidden" value="<?= $idNotaC; ?>">
        <input name="codProducto" type="hidden" value="<?= $codProducto; ?>">
        <input name="cantAnterior" type="hidden" value="<?= intval($detalle['cantProducto']); ?>">
        <div class="mb-3 row">
            <div class="col-4">
                <label class="" for="producto"><strong>Producto</strong></label>
                <input type="text" id="producto" class="form-select" readonly value="<?= $detalle['producto']; ?>">
            </div>
            <div class="col-1">
                <label class="" for="cantProducto"><strong>Cantidad</strong></label>
                <select name="cantProducto" id="cantProducto" class="form-control" required>
                    <option selected value="<?= intval($detalle['cantProducto']); ?>"><?= intval($detalle['cantProducto']); ?></option>
                    <?php
                    for ($i = $cantidadMax; $i > 0; $i--) {
                        if ($i != $detalle['cantProducto']) {
                            echo '<option value=' . $i . '>' . $i . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="col-2 pt-3">
                <button class="button mt-3" type="button" onclick="return Enviar(this.form)"><span>Cambiar</span>
                </button>
            </div>
        </div>
    </form>
</div>
</body>
</html>
