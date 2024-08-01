<?php
include "../../../includes/valAcc.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
if (isset($_POST['idEgreso'])) {//Si la factura existe
    $idEgreso = $_POST['idEgreso'];
}
$tiposCompra = array("1" => "Materia Prima", "2" => "Envase y/o tapas", "3" => "Etiquetas", "5" => "Distribución", "6" => "Gastos");
$EgresoOperador = new EgresoOperaciones();
$egreso = $EgresoOperador->getFormEgreso($idEgreso);
$abono = $EgresoOperador->getPagoXIdTipoCompra($egreso['idCompra'], $egreso['tipoCompra']);
$saldo = intval($egreso['treal']) - $abono;

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Actualización de pago de Facturas de Compra y de Gastos</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>MODIFICACIÓN COMPROBANTE DE EGRESO </h4></div>

    <div class="mb-3 row formatoDatos5">
        <div class="col-1">
            <strong>Id Egreso</strong>
            <div class="bg-blue"><?= $idEgreso; ?></div>
        </div>
        <div class="col-1">
            <strong>Id Compra</strong>
            <div class="bg-blue"><?= $egreso['idCompra'] ?></div>
        </div>
        <div class="col-1">
            <strong>No. Factura</strong>
            <div class="bg-blue"><?= $egreso['numFact'] ?></div>
        </div>
        <div class="col-2">
            <strong>Tipo de compra</strong>
            <div class="bg-blue"><?= $tiposCompra[$egreso['tipoCompra']] ?></div>
        </div>
        <div class="col-2">
            <strong>NIT</strong>
            <div class="bg-blue"><?= $egreso['nitProv'] ?></div>
        </div>
        <div class="col-2">
            <strong>Proveedor</strong>
            <div class="bg-blue"><?= $egreso['nomProv'] ?></div>
        </div>
    </div>
    <div class="mb-3 row formatoDatos5">
        <div class="col-2">
            <strong>Fecha de compra</strong>
            <div class="bg-blue"><?= $egreso['fechComp']; ?></div>
        </div>
        <div class="col-2">
            <strong>Fecha Vencimiento </strong>
            <div class="bg-blue"><?= $egreso['fechVenc'] ?></div>
        </div>
        <div class="col-1">
            <strong>Valor Factura</strong>
            <div class="bg-blue"><?= $egreso['total'] ?></div>
        </div>
        <div class="col-1">
            <strong>Retención</strong>
            <div class="bg-blue"><?= $egreso['retefuente'] ?></div>
        </div>
        <div class="col-1">
            <strong>Rete Ica</strong>
            <div class="bg-blue"><?= $egreso['reteica'] ?></div>
        </div>
        <div class="col-1">
            <strong>Valor a Pagar</strong>
            <div class="bg-blue"><?= $egreso['vreal'] ?></div>
        </div>
        <div class="col-1">
            <strong>Valor pagado</strong>
            <div class="bg-blue"><?= $egreso['pago'] ?></div>
        </div>
    </div>
    <div class="mb-3 row">&nbsp;</div>
    <form method="post" action="updateEgreso.php" name="form1">
        <input name="idEgreso" type="hidden" value="<?= $idEgreso; ?>">
        <input name="modEgreso" type="hidden" value="1">
        <div class="row mb-3">
            <div class="col-2">
                <label class="form-label" for="fechPago"><strong>Fecha del Pago</strong></label>
                <input type="date" class="form-control" value="<?= $egreso['fechPago']; ?>" name="fechPago" id="fechPago">
            </div>
            <div class="col-2">
                <label class="form-label" for="formPago"><strong>Forma de Pago</strong></label>
                <?php
                $manager = new FormaPagoOperaciones();
                $formas = $manager->getFormasPago();
                $filas = count($formas);
                echo '<select name="formPago" id="formPago" class="form-control" required>';
                echo '<option selected value="' . $egreso['formPago'] . '">' . $egreso['formaPago'] . '</option>';
                for ($i = 0; $i < $filas; $i++) {
                    if ($egreso['formPago'] != $formas[$i]["idFormaPago"]) {
                        echo '<option value="' . $formas[$i]["idFormaPago"] . '">' . $formas[$i]['formaPago'] . '</option>';
                    }
                }
                echo '</select>';
                ?>
            </div>
            <div class="col-1">
                <label class="form-label" for="pago"><strong>Pago</strong></label>
                <input type="text" class="form-control col-1" name="pago" id="pago" value="<?= $egreso['pagon']; ?>" onkeydown="return aceptaNum(event)">
            </div>
            <div class="col-1">
                <label class="form-label" for="descuentoE"><strong>Descuento</strong></label>
                <input type="text" class="form-control col-1" name="descuentoE" id="descuentoE" onkeydown="return aceptaNum(event)" value="<?= $egreso['descuentoE']; ?>">
            </div>
            <div class="col-2 pt-3">
                <button class="button mt-3" type="button" onclick="return Enviar(this.form)"><span>Actualizar pago</span> </button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-1">
            <button class="button" onClick="window.location='../facturas-por-pagar'"><span>Terminar</span></button>
        </div>
    </div>
</div>
</body>
</html>