<?php
include "../../../includes/valAcc.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
if (isset($_SESSION['idEgreso'])) {//Si la factura existe
    $idEgreso = $_SESSION['idEgreso'];
}
$tiposCompra = array("1" => "Materia Prima", "2" => "Envase y/o tapas", "3" => "Etiquetas", "5" => "Distribución", "6" => "Gastos");
$EgresoOperador = new EgresoOperaciones();
$egreso = $EgresoOperador->getFormEgreso($idEgreso);
//var_dump($egreso); die;
$abono = $EgresoOperador->getPagoXIdTipoCompra($egreso['idCompra'], $egreso['tipoCompra']);
$saldo = intval($egreso['treal']) - $abono;

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Pago de Facturas de Compra y de Gastos</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
<script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2"><h4>COMPROBANTE DE EGRESO POR FACTURAS DE COMPRA Y GASTOS</h4></div>

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
        <div class="col-1">
            <strong>NIT</strong>
            <div class="bg-blue"><?= $egreso['nitProv'] ?></div>
        </div>
        <div class="col-3">
            <strong>Proveedor</strong>
            <div class="bg-blue"><?= $egreso['nomProv'] ?></div>
        </div>
        <div class="col-1">
            <strong>Valor Factura</strong>
            <div class="bg-blue"><?= $egreso['total'] ?></div>
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
            <strong>Retención</strong>
            <div class="bg-blue"><?= $egreso['retefuente'] ?></div>
        </div>
        <div class="col-1">
            <strong>Rete Ica</strong>
            <div class="bg-blue"><?= $egreso['reteica'] ?></div>
        </div>
        <div class="col-1">
            <strong>Rete Iva</strong>
            <div class="bg-blue"><?= $egreso['reteiva'] ?></div>
        </div>
        <div class="col-1">
            <strong>Valor a Pagar</strong>
            <div class="bg-blue"><?= $egreso['vreal'] ?></div>
        </div>
        <div class="col-1">
            <strong>Valor pagado</strong>
            <div class="bg-blue"><?= $egreso['pago'] ?></div>
        </div>
        <div class="col-1">
            <strong>Saldo</strong>
            <div class="bg-blue"><?= "$".number_format($saldo,0,".",",")  ?></div>
        </div>
    </div>
    <div class="mb-3 row">&nbsp;</div>
    <?php if ($egreso['vlr_pago'] == 0): ?>
        <form method="post" action="updateEgreso.php" name="form1">
            <input name="idEgreso" type="hidden" value="<?= $idEgreso; ?>">
            <div class="row mb-3 formatoDatos5">
                <div class="col-2">
                    <label class="form-label" for="fechPago"><strong>Fecha del Pago</strong></label>
                    <input type="date" class="form-control" name="fechPago" id="fechPago">
                </div>
                <div class="col-2">
                    <label class="form-label" for="formPago"><strong>Forma de Pago</strong></label>
                    <?php
                    $manager = new FormaPagoOperaciones();
                    $formas = $manager->getFormasPago();
                    $filas = count($formas);
                    echo '<select name="formPago" id="formPago" class="form-control" required>';
                    echo '<option disabled selected value="">Seleccione una opción</option>';
                    for ($i = 0; $i < $filas; $i++) {
                        echo '<option value="' . $formas[$i]["idFormaPago"] . '">' . $formas[$i]['formaPago'] . '</option>';
                    }
                    echo '</select>';
                    ?>
                </div>
                <div class="col-1">
                    <label class="form-label" for="pago"><strong>Pago</strong></label>
                    <input type="text" class="form-control col-1" name="pago" id="pago" value="<?= $saldo; ?>" onkeydown="return aceptaNum(event)">
                </div>
                <div class="col-1">
                    <label class="form-label" for="descuentoE"><strong>Descuento</strong></label>
                    <input type="text"  class="form-control col-1" name="descuentoE" id="descuentoE" onkeydown="return aceptaNum(event)" value="0">
                </div>
                <div class="col-2 pt-3">
                    <button class="button mt-3" type="button" onclick="return Enviar(this.form)"><span>Adicionar pago</span> </button>
                </div>
            </div>
            <div class="mb-3 row">


                <div class="col-2">

                </div>
            </div>
        </form>
    <?php else: ?>
        <div class="mb-3 row">
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
    <div class="mb-3 row titulo">Detalle comprobante de egreso :</div>
    <div class="mb-3 row formatoDatos5">
        <div class="col-1"><strong>No. Pago</strong></div>
        <div class="col-1"><strong>Fecha</strong></div>
        <div class="col-1"><strong>Pago</strong></div>
        <div class="col-1"><strong>Descuento</strong></div>
        <div class="col-1"><strong>Forma de Pago</strong></div>
        <?php if($egreso['estadoCompra']!=7): ?>
        <div class="col-1"></div>
        <?php endif; ?>
    </div>
    <?php
        for($i=0; $i<count($egresos); $i++):
    ?>

    <div class="mb-3 row formatoDatos5">
        <div class="col-1 "><?= $i+1 ?></div>
        <div class="col-1"><?= $egresos[$i]['fechPago'] ?></div>
        <div class="col-1"><?= $egresos[$i]['pago'] ?></div>
        <div class="col-1"><?= $egresos[$i]['descuento'] ?></div>
        <div class="col-1"><?= $egresos[$i]['formaPago'] ?></div>
        <?php if($egreso['estadoCompra']!=7): ?>
        <div class="col-1">
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
        <div class="col-1"><button class="button"  onClick="window.location='../facturas-por-pagar'"><span>Terminar</span></button></div>
    </div>
</div>
</body>
</html>