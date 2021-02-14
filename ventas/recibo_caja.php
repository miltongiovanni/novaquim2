<?php
include "../includes/valAcc.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
if (isset($_POST['idRecCaja'])) {
    $idRecCaja = $_POST['idRecCaja'];
} elseif (isset($_SESSION['idRecCaja'])) {//Si la factura existe
    $idRecCaja = $_SESSION['idRecCaja'];
}
$_SESSION['idRecCaja'] = $idRecCaja;
$reciboOperador = new RecCajaOperaciones();
$recibo = $reciboOperador->getRecCaja($idRecCaja);
$cobros = $reciboOperador->getCobrosFactura($recibo['idFactura']);
$recibos = $reciboOperador->getRecCajaFactura($recibo['idFactura']);
$abono = $reciboOperador->getCobrosAnterioresFactura($recibo['idFactura'], $idRecCaja);
$abono = $abono == null ? 0 : $abono;
$retefuente = $recibo['retencionFte'];
$retencionIca = $recibo['retencionIca'];
$subtotal = $recibo['subtotal'];
if ($retefuente > 0) {
    $tasaRetefuente = round($retefuente / $subtotal, 3);
} else {
    $tasaRetefuente = 0;
}
$saldo = round($recibo['totalR'] - $recibo['retencionFte'] - $recibo['retencionIca'] - $recibo['retencionIva'] - $abono - $recibo['cobro']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Recibo de caja</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>

    <script src="../js/jquery-3.3.1.min.js"></script>
    <script>
        function redireccion() {
            window.location.href = "../menu.php";
        }

        function eliminarSession() {
            let variable = 'idRecCaja';
            $.ajax({
                url: '../includes/controladorVentas.php',
                type: 'POST',
                data: {
                    "action": 'eliminarSession',
                    "variable": variable,
                },
                dataType: 'text',
                success: function (res) {
                    redireccion();
                },
                error: function () {
                    alert("Vous avez un GROS problème");
                }
            });
        }

        function retefuente() {
            let retencion = document.getElementById("retencion").value;
            document.getElementById("updateRecCajaForm").style.display = 'none';
            document.getElementById("impRecCajaForm").style.display = 'none';
            document.getElementById("detalleCobros").style.display = 'none';
            if (retencion == 0) {
                document.getElementById("t_reten").value = "0";
                aplicarRetefuente();
            }

        }

        function aplicarRetefuente() {
            let tasaRetencion = document.getElementById("t_reten").value;
            let idFactura = <?=$recibo['idFactura'] ?>;
            $.ajax({
                url: '../includes/controladorVentas.php',
                type: 'POST',
                data: {
                    "action": 'aplicarRetefuente',
                    "tasaRetencion": tasaRetencion,
                    "idFactura": idFactura,
                },
                dataType: 'text',
                success: function (response) {
                    //document.location.reload();
                    self.location = 'recibo_caja';
                },
                error: function () {
                    alert("Vous avez un GROS problème");
                }
            });
        }

        function aplicarReteica() {
            let tasaRetencion;
            if (document.getElementById("retica").value == 0) {
                tasaRetencion = 0;
            } else {
                tasaRetencion = 0.01104;
            }
            let idFactura = <?=$recibo['idFactura'] ?>;
            $.ajax({
                url: '../includes/controladorVentas.php',
                type: 'POST',
                data: {
                    "action": 'aplicarReteica',
                    "tasaRetencion": tasaRetencion,
                    "idFactura": idFactura,
                },
                dataType: 'text',
                success: function (response) {
                    self.location = 'recibo_caja';
                },
                error: function () {
                    alert("Vous avez un GROS problème");
                }
            });
        }
    </script>

</head>
<body>
<div id="contenedor">
    <div id="saludo1"><strong>RECIBO DE CAJA POR COBRO DE FACTURAS DE VENTA</strong></div>

    <div class="form-group row">
        <div class="col-1 text-right"><strong>Recibo de caja:</strong></div>
        <div class="col-1 bg-blue"><?= $idRecCaja; ?></div>
        <div class="col-1 text-right"><strong>Cliente:</strong></strong></div>
        <div class="col-3 bg-blue"><?= $recibo['nomCliente'] ?></div>
        <div class="col-1 text-right"><strong>NIT:</strong></div>
        <div class="col-1 bg-blue"><?= $recibo['nitCliente'] ?></div>
    </div>
    <div class="form-group row">
        <div class="col-1 text-right"><strong>No. de factura:</strong></div>
        <div class="col-1 bg-blue"><?= $recibo['idFactura'] ?></div>
        <div class="col-2 text-right"><strong>Fecha de Factura:</strong></div>
        <div class="col-1 bg-blue"><?= $recibo['fechaFactura'] ?></div>
        <div class="col-2 text-right"><strong>Fecha Vencimiento:</strong></strong></div>
        <div class="col-1 bg-blue"><?= $recibo['fechaVenc'] ?></div>
    </div>
    <div class="form-group row">
        <div class="col-1 text-right"><strong>Valor Factura:</strong></div>
        <div class="col-1 bg-blue"><?= '$' . number_format($recibo['total'], 0, '.', ',') ?></div>
        <div class="col-1 text-right"><strong>Retefuente:</strong></div>
        <div class="col-1 bg-blue"><?= '$' . number_format($recibo['retencionFte'], 0, '.', ',') ?></div>
        <div class="col-1 text-right"><strong>ReteIca:</strong></strong></div>
        <div class="col-1 bg-blue"><?= '$' . number_format($recibo['retencionIca'], 0, '.', ',') ?></div>
        <div class="col-1 text-right"><strong>ReteIva:</strong></div>
        <div class="col-1 bg-blue"><?= '$' . number_format($recibo['retencionIva'], 0, '.', ','); ?></div>
    </div>
    <div class="form-group row">
        <div class="col-1 text-right"><strong>Valor a Cobrar:</strong></div>
        <div class="col-1 bg-blue"><?= '$' . number_format($recibo['totalR'] - $recibo['retencionFte'] - $recibo['retencionIca'] - $recibo['retencionIva'], 0, '.', ',') ?></div>
        <div class="col-2 text-right"><strong>Valor Cancelado: </strong></strong></div>
        <div class="col-1 bg-blue"><?= '$' . number_format($abono + $recibo['cobro'], 0, '.', ',') ?></div>
        <div class="col-2 text-right"><strong>Valor Pendiente:</strong></div>
        <div class="col-1 bg-blue"><?= '$' . number_format($recibo['totalR'] - $recibo['retencionFte'] - $recibo['retencionIca'] - $recibo['retencionIva'] - $abono - $recibo['cobro'], 0, '.', ',') ?></div>
    </div>

    <div class="row form-group my-5">
        <label for="retencion" class="col-form-label col-2 text-right"><strong>Cliente aplicó retención</strong></label>
        <select name="retencion" id="retencion" class="form-control col-1" onchange="retefuente()">
            <option <?= $retefuente == 0 ? 'selected' : '' ?> value=0>No</option>
            <option <?= $retefuente > 0 ? 'selected' : '' ?> value=1>Si</option>
        </select>
        <label for="t_reten" class="col-form-label col-2 text-right"><strong>Tasa retención en la
                fuente</strong></label>
        <select name="t_reten" id="t_reten" class="form-control col-1" onchange="aplicarRetefuente()">
            <option <?= $tasaRetefuente == 0.025 ? 'selected' : '' ?> value=0.025>2.5%</option>
            <option <?= $tasaRetefuente == 0.015 ? 'selected' : '' ?> value=0.015>1.5%</option>
            <option <?= $tasaRetefuente == 0.035 ? 'selected' : '' ?> value=0.035>3.5%</option>
            <option <?= $tasaRetefuente == 0.04 ? 'selected' : '' ?> value=0.04>4%</option>
            <option <?= $tasaRetefuente == 0 ? 'selected' : '' ?> value=0>0%</option>
        </select>
        <label for="retica" class="col-form-label col-2 text-right"><strong>Aplicó retención de ICA</strong></label>
        <select name="retica" id="retica" class="form-control col-1" onchange="aplicarReteica()">
            <option <?= $retencionIca == 0 ? 'selected' : '' ?> value=0>No</option>
            <option <?= $retencionIca > 0 ? 'selected' : '' ?> value=1>Si</option>
        </select>
    </div>

    <form method="post" action="updateRecCaja.php" name="form1" id="updateRecCajaForm">
        <input name="idRecCaja" type="hidden" value="<?= $idRecCaja; ?>">
        <input name="idFactura" type="hidden" value="<?= $recibo['idFactura']; ?>">
        <input name="reten" type="hidden" value="<?= $retefuente > 0 ? 1 : 0 ?>">
        <input name="reten_ica" type="hidden" value="<?= $retencionIca > 0 ? 1 : 0 ?>">
        <div class="row form-group">
            <div class="text-center input-date"><strong>Fecha cobro</strong></div>
            <div class="input-date text-center ml-1"><strong>Forma de pago</strong></div>
            <div class="col-1 text-center mx-1"><strong>Banco</strong></div>
            <div class="col-1 text-center mx-1"><strong>No. Cheque</strong></div>
            <div class="col-1 text-center mx-1"><strong>Vlr pagado</strong></div>
            <div class="col-1 text-center mx-1"><strong>Descuento</strong></div>
            <div class="col-2 text-center">
            </div>
        </div>
        <div class="form-group row">
            <input type="date" class="form-control input-date"
                   name="fechaRecCaja" id="fechaRecCaja" value="<?= $recibo['fechaRecCaja'] ?>">
            <select name="form_pago" id="form_pago" class="form-control input-date ml-1" required>
                <?php
                $manager = new FormaPagoOperaciones();
                $formas = $manager->getFormasPago();
                $filas = count($formas);
                for ($i = 0; $i < $filas; $i++) :
                    ?>
                    <option <?= $formas[$i]["idFormaPago"] == $recibo['form_pago'] ? 'selected' : '' ?>
                            value="<?= $formas[$i]["idFormaPago"] ?>"><?= $formas[$i]['formaPago'] ?></option>
                <?php
                endfor;
                ?>
            </select>
            <select name="codBanco" id="codBanco" class="form-control col-1 mx-1" required>
                <?php
                $manager = new BancosOperaciones();
                $bancos = $manager->getBancos();
                $filas = count($bancos);
                for ($i = 0;
                     $i < $filas;
                     $i++) :
                    ?>
                    <option <?= $bancos[$i]["idBanco"] == $recibo['codBanco'] ? 'selected' : '' ?>
                            value="<?= $bancos[$i]["idBanco"] ?>"><?= $bancos[$i]['banco'] ?></option>
                <?php
                endfor;
                ?>
            </select>
            <input type="text" class="form-control col-1 mx-1" name="idCheque"
                   id="idCheque" value="<?= $recibo['idCheque']; ?>"
                   onKeyPress="return aceptaNum(event)">
            <input type="text" class="form-control col-1 mx-1" name="cobro"
                   id="cobro"
                   value="<?= round($recibo['totalR'] - $recibo['retencionFte'] - $recibo['retencionIca'] - $recibo['retencionIva'] - $abono) ?>"
                   onKeyPress="return aceptaNum(event)">
            <input type="text" class="form-control col-1 mx-1" name="descuento_f" id="descuento_f"
                   onKeyPress="return aceptaNum(event)" value="<?= $recibo['descuento_f']; ?>">
            <div class="col-2 text-center" style="padding: 0 20px;">
                <button class="button" type="button" onclick="return Enviar(this.form)"><span>Actualizar valor</span>
                </button>
            </div>
        </div>
    </form>
    <div class="form-group row" id="impRecCajaForm">
        <div class="col-2">
            <form action="Imp_Recibo_Caja.php" method="post" target="_blank">
                <input name="idRecCaja" type="hidden" value="<?= $idRecCaja; ?>">
                <button class="button" type="submit">
                    <span><STRONG>Imprimir Recibo de caja</STRONG></span></button>
            </form>
        </div>
    </div>
    <div id="detalleCobros">
        <div class="form-group row titulo">Detalle cobros factura :</div>
        <div class="form-group row">
            <div class="col-1 text-center"><strong>Recibo Caja</strong></div>
            <div class="col-1 text-center"><strong>Fecha</strong></div>
            <div class="col-1 text-center"><strong>Pago</strong></div>
            <div class="col-1 text-center"><strong>Forma de Pago</strong></div>
        </div>
        <?php
        for ($i = 0; $i < count($recibos); $i++):
            ?>
            <div class="form-group row">
                <div class="col-1 text-center"><?= $recibos[$i]['idRecCaja'] ?></div>
                <div class="col-1 text-center"><?= $recibos[$i]['fechaRecCaja'] ?></div>
                <div class="col-1 text-center"><?= $recibos[$i]['pago'] ?></div>
                <div class="col-1 text-center"><?= $recibos[$i]['formaPago'] ?></div>
            </div>
        <?php
        endfor;
        ?>
    </div>

    <div class="row">
        <div class="col-1">
            <button class="button" onClick="eliminarSession()"><span>Terminar</span></button>
        </div>
    </div>
</div>
</body>
</html>