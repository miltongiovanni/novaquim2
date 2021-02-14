<?php
include "../includes/valAcc.php";
$idNotaC = $_POST['idNotaC'];
$codProducto = $_POST['codProducto'];
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
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
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar datos de la Nota Crédito</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>

</head>
<body>
<div id="contenedor">
    <div id="saludo"><strong>ACTUALIZACIÓN DEL PRODUCTO EN LA NOTA CRÉDITO</strong></div>
    <form action="updateProdNota.php" method="post" name="actualiza">
        <input name="idNotaC" type="hidden" value="<?= $idNotaC; ?>">
        <input name="codProducto" type="hidden" value="<?= $codProducto; ?>">
        <input name="cantAnterior" type="hidden" value="<?= intval($detalle['cantProducto']); ?>">
        <div class="row">
            <label class="col-4 text-center" style="margin: 0 5px;" for="producto"><strong>Producto</strong></label>
            <label class="col-1 text-center" style="margin: 0 5px;" for="cantProducto"><strong>Cantidad</strong></label>
            <div class="col-2 text-center"></div>
        </div>
        <div class="form-group row">
            <input type="text" id="producto" class="form-control col-4 mr-3" readonly
                   value="<?= $detalle['producto']; ?>">
            <select name="cantProducto" id="cantProducto" class="form-control col-1" required>
                <option selected
                        value="<?= intval($detalle['cantProducto']); ?>"><?= intval($detalle['cantProducto']); ?></option>
                <?php
                for ($i = $cantidadMax; $i > 0; $i--) {
                    if ($i != $detalle['cantProducto']) {
                        echo '<option value=' . $i . '>' . $i . '</option>';
                    }
                }
                ?>
            </select>
            <div class="col-2 text-center" style="padding: 0 20px;">
                <button class="button" type="button" onclick="return Enviar(this.form)"><span>Cambiar</span>
                </button>
            </div>
        </div>

    </form>
</div>
</body>
</html>
