<?php
include "../includes/valAcc.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
if (isset($_SESSION['idEgreso'])) {//Si la factura existe
    $idEgreso = $_SESSION['idEgreso'];
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
    <title>Pago de Facturas de Compra y de Gastos</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>COMPROBANTE DE EGRESO POR FACTURAS DE COMPRA Y GASTOS</h4></div>

    <div class="form-group row">
        <div class="col-1 text-end"><strong>Id Egreso</strong></div>
        <div class="col-1 bg-blue"><?= $idEgreso; ?></div>
        <div class="col-1 text-end"><strong>Id Compra</strong></strong></div>
        <div class="col-1 bg-blue"><?= $egreso['idCompra'] ?></div>
        <div class="col-1 text-end"><strong>No. de Factura</strong></div>
        <div class="col-1 bg-blue"><?= $egreso['numFact'] ?></div>
    </div>
    <div class="form-group row">
        <div class="col-2 text-end"><strong>Tipo de compra</strong></div>
        <div class="col-1 bg-blue"><?= $tiposCompra[$egreso['tipoCompra']] ?></div>
        <div class="col-1 text-end"><strong>NIT</strong></div>
        <div class="col-1 bg-blue"><?= $egreso['nitProv'] ?></div>
        <div class="col-1 text-end"><strong>Proveedor</strong></strong></div>
        <div class="col-2 bg-blue"><?= $egreso['nomProv'] ?></div>
    </div>
    <div class="form-group row">
        <div class="col-1 text-end"><strong>Valor Factura</strong></div>
        <div class="col-1 bg-blue"><?= $egreso['total'] ?></div>
        <div class="col-2 text-end"><strong>Fecha de compra</strong></div>
        <div class="col-1 bg-blue"><?= $egreso['fechComp']; ?></div>
        <div class="col-2 text-end"><strong>Fecha Vencimiento </strong></strong></div>
        <div class="col-1 bg-blue"><?= $egreso['fechVenc'] ?></div>
    </div>
    <div class="form-group row">
        <div class="col-1 text-end"><strong>Retención</strong></div>
        <div class="col-1 bg-blue"><?= $egreso['retefuente'] ?></div>
        <div class="col-1 text-end"><strong>Rete Ica</strong></strong></div>
        <div class="col-1 bg-blue"><?= $egreso['reteica'] ?></div>
        <div class="col-1 text-end"><strong>Rete Iva</strong></strong></div>
        <div class="col-1 bg-blue"><?= $egreso['reteiva'] ?></div>
    </div>
    <div class="form-group row">
        <div class="col-1 text-end"><strong>Valor a Pagar</strong></div>
        <div class="col-1 bg-blue"><?= $egreso['vreal'] ?></div>
        <div class="col-1 text-end"><strong>Valor pagado</strong></div>
        <div class="col-1 bg-blue"><?= $egreso['pago'] ?></div>
        <div class="col-1 text-end"><strong>Saldo</strong></div>
        <div class="col-1 bg-blue"><?= "$".number_format($saldo,0,".",",")  ?></div>
    </div>
    <div class="form-group row">
    </div>
    <div class="form-group row">&nbsp;</div>
    <?php if ($egreso['vlr_pago'] == 0): ?>
        <form method="post" action="updateEgreso.php" name="form1">
            <input name="idEgreso" type="hidden" value="<?= $idEgreso; ?>">
            <div class="row form-group">
                <div class=" text-center input-date"><strong>Fecha del
                        Pago</strong></div>
                <div class="col-1 text-center" style="margin: 0 5px;"><strong>Forma de Pago</strong></div>
                <div class="col-1 text-center" style="margin: 0 5px;"><strong>Pago</strong></div>
                <div class="col-1 text-center" style="margin: 0 5px;"><strong>Descuento</strong></div>
                <div class="col-2 text-center">
                </div>
            </div>
            <div class="form-group row">
                <input type="date" class="form-control input-date"
                       name="fechPago" id="fechPago">
                <?php
                $manager = new FormaPagoOperaciones();
                $formas = $manager->getFormasPago();
                $filas = count($formas);
                echo '<select name="formPago" id="formPago" class="form-control col-1" style="margin: 0 5px;" required>';
                echo '<option disabled selected value="">---------------</option>';
                for ($i = 0; $i < $filas; $i++) {
                    echo '<option value="' . $formas[$i]["idFormaPago"] . '">' . $formas[$i]['formaPago'] . '</option>';
                }
                echo '</select>';
                ?>
                <input type="text" style="margin: 0 5px;" class="form-control col-1" name="pago"
                       id="pago" value="<?= $saldo; ?>"
                       onkeydown="return aceptaNum(event)">
                <input type="text" style="margin: 0 5px;" class="form-control col-1" name="descuentoE" id="descuentoE"
                       onkeydown="return aceptaNum(event)" value="0">
                <div class="col-2 text-center" style="padding: 0 20px;">
                    <button class="button" type="button" onclick="return Enviar(this.form)"><span>Adicionar pago</span>
                    </button>
                </div>
            </div>
        </form>
    <?php else: ?>
        <div class="form-group row">
            <div class="col-2">
                <form action="Imp_Egreso.php" method="post" target="_blank">
                    <input name="idEgreso" type="hidden" value="<?= $idEgreso; ?>">
                    <button class="button" type="submit">
                        <span><STRONG>Imprimir Comprobante</STRONG></span></button>
                </form>
            </div>
        </div>
    <?php endif; ?>
    <?php
    $egresos = $EgresoOperador->getPagosXIdTipoCompra($egreso['idCompra'], $egreso['tipoCompra']);
    if($egresos[0]['fechPago']!=''):
    ?>
    <div class="form-group row titulo">Detalle comprobante de egreso :</div>
    <div class="form-group row">
        <div class="col-1 text-center"><strong>No. Pago</strong></div>
        <div class="col-1 text-center"><strong>Fecha</strong></div>
        <div class="col-1 text-center"><strong>Pago</strong></div>
        <div class="col-1 text-center"><strong>Descuento</strong></div>
        <div class="col-1 text-center"><strong>Forma de Pago</strong></div>
        <?php if($egreso['estadoCompra']!=7): ?>
        <div class="col-1 text-center"></div>
        <?php endif; ?>
    </div>
    <?php
        for($i=0; $i<count($egresos); $i++):
    ?>

    <div class="form-group row">
        <div class="col-1 text-center "><?= $i+1 ?></div>
        <div class="col-1 text-center"><?= $egresos[$i]['fechPago'] ?></div>
        <div class="col-1 text-center"><?= $egresos[$i]['pago'] ?></div>
        <div class="col-1 text-center"><?= $egresos[$i]['descuento'] ?></div>
        <div class="col-1 text-center"><?= $egresos[$i]['formaPago'] ?></div>
        <?php if($egreso['estadoCompra']!=7): ?>
        <div class="col-1 text-center">
            <form action="updateEgresoForm.php" method="post" name="elimina">
                <input name="idEgreso" type="hidden" value="<?= $idEgreso; ?>">
                <input type="button" onclick="return Enviar(this.form)" class="formatoBoton"  value="Modificar">
            </form>
        </div>
        <?php endif; ?>
    </div>
    <?php
    endfor;
    endif;
    ?>
    <div class="row">
        <div class="col-1"><button class="button"  onClick="window.location='factXpagar.php'"><span>Terminar</span></button></div>
    </div>
</div>
</body>
</html>