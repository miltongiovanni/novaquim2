<?php
include "../includes/valAcc.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
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
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor">
    <div id="saludo1"><strong>MODIFICACIÓN COMPROBANTE DE EGRESO </strong></div>

    <div class="form-group row">
        <div class="col-1 text-right"><strong>Id Egreso</strong></div>
        <div class="col-1 bg-blue"><?= $idEgreso; ?></div>
        <div class="col-1 text-right"><strong>Id Compra</strong></strong></div>
        <div class="col-1 bg-blue"><?= $egreso['idCompra'] ?></div>
        <div class="col-1 text-right"><strong>No. de Factura</strong></div>
        <div class="col-1 bg-blue"><?= $egreso['numFact'] ?></div>
    </div>
    <div class="form-group row">
        <div class="col-2 text-right"><strong>Tipo de compra</strong></div>
        <div class="col-2 bg-blue"><?= $tiposCompra[$egreso['tipoCompra']] ?></div>
        <div class="col-1 text-right"><strong>Valor Factura</strong></div>
        <div class="col-1 bg-blue"><?= $egreso['total'] ?></div>
    </div>
    <div class="form-group row">
        <div class="col-2 text-right"><strong>Proveedor</strong></strong></div>
        <div class="col-2 bg-blue"><?= $egreso['nomProv'] ?></div>
        <div class="col-1 text-right"><strong>Retención</strong></div>
        <div class="col-1 bg-blue"><?= $egreso['retefuente'] ?></div>
    </div>
    <div class="form-group row">
        <div class="col-2 text-right"><strong>NIT</strong></div>
        <div class="col-2 bg-blue"><?= $egreso['nitProv'] ?></div>
        <div class="col-1 text-right"><strong>Rete Ica</strong></strong></div>
        <div class="col-1 bg-blue"><?= $egreso['reteica'] ?></div>
    </div>
    <div class="form-group row">
        <div class="col-2 text-right"><strong>Fecha de compra</strong></div>
        <div class="col-2 bg-blue"><?= $egreso['fechComp']; ?></div>
        <div class="col-1 text-right"><strong>Valor a Pagar</strong></div>
        <div class="col-1 bg-blue"><?= $egreso['vreal'] ?></div>
    </div>
    <div class="form-group row">
        <div class="col-2 text-right"><strong>Fecha Vencimiento </strong></strong></div>
        <div class="col-2 bg-blue"><?= $egreso['fechVenc'] ?></div>
        <div class="col-1 text-right"><strong>Valor pagado</strong></div>
        <div class="col-1 bg-blue"><?= $egreso['pago'] ?></div>
    </div>
    <div class="form-group row">&nbsp;</div>
    <form method="post" action="updateEgreso.php" name="form1">
        <input name="idEgreso" type="hidden" value="<?= $idEgreso; ?>">
        <input name="modEgreso" type="hidden" value="1">
        <div class="row form-group">
            <div class=" text-center" style="margin: 0 5px 0 0 ; flex: 0 0 10%; max-width: 10%;"><strong>Fecha del
                    Pago</strong></div>
            <div class="col-1 text-center" style="margin: 0 5px;"><strong>Forma de Pago</strong></div>
            <div class="col-1 text-center" style="margin: 0 5px;"><strong>Pago</strong></div>
            <div class="col-1 text-center" style="margin: 0 5px;"><strong>Descuento</strong></div>
            <div class="col-2 text-center">
            </div>
        </div>
        <div class="form-group row">
            <input type="date" style="margin: 0 5px 0 0 ; flex: 0 0 10%; max-width: 10%;" class="form-control" value="<?= $egreso['fechPago']; ?>"
                   name="fechPago" id="fechPago">
            <?php
            $manager = new FormaPagoOperaciones();
            $formas = $manager->getFormasPago();
            $filas = count($formas);
            echo '<select name="formPago" id="formPago" class="form-control col-1" style="margin: 0 5px;">';
            echo '<option selected value="'.$egreso['formPago'].'">'.$egreso['formaPago'].'</option>';
            for ($i = 0; $i < $filas; $i++) {
                if ($egreso['formPago']!=$formas[$i]["idFormaPago"]){
                    echo '<option value="' . $formas[$i]["idFormaPago"] . '">' . $formas[$i]['formaPago'] . '</option>';
                }
            }
            echo '</select>';
            ?>
            <input type="text" style="margin: 0 5px;" class="form-control col-1" name="pago"
                   id="pago" value="<?= $egreso['pagon']; ?>"
                   onKeyPress="return aceptaNum(event)">
            <input type="text" style="margin: 0 5px;" class="form-control col-1" name="descuentoE" id="descuentoE"
                   onKeyPress="return aceptaNum(event)" value="<?= $egreso['descuentoE']; ?>">
            <div class="col-2 text-center" style="padding: 0 20px;">
                <button class="button" onclick="return Enviar(this.form)"><span>Modificar pago</span>
                </button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-1">
            <button class="button" onClick="window.location='factXpagar.php'"><span>Terminar</span></button>
        </div>
    </div>
</div>
</body>
</html>