<?php
include "../includes/valAcc.php";
if (isset($_POST['idCambio'])) {
    $idCambio = $_POST['idCambio'];
} else {
    if (isset($_SESSION['idCambio'])) {
        $idCambio = $_SESSION['idCambio'];
    }
}

if (isset($_SESSION['presOrigen'])) {
    $presOrigen = $_SESSION['presOrigen'];
} else {
    $presOrigen = false;
}

if (isset($_SESSION['presDestino'])) {
    $presDestino = $_SESSION['presDestino'];
} else {
    $presDestino = false;
}

function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$cambioOperador = new CambiosOperaciones();
$cambio = $cambioOperador->getCambio($idCambio);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Cambio de presentación de Producto</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script>
        function redireccion() {
            window.location.href = "../menu.php";
        }

        function eliminarSession() {
            let variables = 'idCambio,presOrigen,presDestino';
            $.ajax({
                url: '../includes/controladorProduccion.php',
                type: 'POST',
                data: {
                    "action": 'eliminarSession',
                    "variables": variables,
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
        function findLotePresentacion(codPresentacion) {
            //alert(idCatProd);
            $.ajax({
                url: '../includes/controladorProduccion.php',
                type: 'POST',
                data: {
                    "action": 'findLotePresentacion',
                    "codPresentacion": codPresentacion
                },
                dataType: 'json',
                success: function (lotes) {
                    rep = '<option selected disabled value="">------</option>';
                    for (let i = 0; i < lotes.length; i++) {
                        rep += '<option value="' + lotes[i].loteProd + '">' + lotes[i].loteProd + '</option>';
                    }
                    document.getElementById('loteProd').innerHTML = rep;
                },
                error: function () {
                    alert("Vous avez un GROS problème");
                }
            });
        }

        function findInvLotePresentacion(loteProd) {
            //alert(loteProd);
            $.ajax({
                url: '../includes/controladorProduccion.php',
                type: 'POST',
                data: {
                    "action": 'findInvLotePresentacion',
                    "codPresentacion": document.getElementById('codPresentacionAnt').value,
                    "loteProd": loteProd,
                },
                dataType: 'json',
                success: function (inv) {
                    rep = '<option selected disabled value="">------</option>';
                    for (let j = 1; j <= inv; j++) {
                        rep += '<option value="' + j + '">' + j + '</option>';
                    }
                    document.getElementById('cantPresentacionAnt').innerHTML = rep;

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
    <div id="saludo1"><strong>CAMBIO DE PRESENTACIÓN DE PRODUCTO</strong></div>
    <div class="form-group row">
        <div class="col-1 text-right"><strong>Cambio</strong></div>
        <div class="col-1 bg-blue"><?= $idCambio; ?></div>
        <div class="col-2 text-right"><strong>Fecha de cambio</strong></div>
        <div class="col-1 bg-blue"><?= $cambio['fechaCambio'] ?></div>
        <div class="col-1 text-right"><strong>Responsable</strong></div>
        <div class="col-2 bg-blue"><?= $cambio['nomPersonal'] ?></div>
    </div>
    <div class="form-group titulo row">
        Origen
    </div>
    <?php
    if ($presOrigen == false):
        ?>
        <form method="post" action="makeDetCambio.php" name="form1">
            <input name="idCambio" type="hidden" value="<?= $idCambio; ?>">
            <div class="row">
                <div class="col-4 text-center" style="margin: 0 5px 0 0;"><strong>Presentación</strong></div>
                <div class="col-1 text-center" style="margin: 0 5px;"><strong>Lote</strong></div>
                <div class="col-1 text-center" style="margin: 0 5px;"><strong>Unidades</strong></div>
                <div class="col-2 text-center">
                </div>
            </div>
            <div class="form-group row">
                <select name="codPresentacionAnt" id="codPresentacionAnt" class="form-control col-4"
                        style="margin: 0 5px 0 0;" onchange="findLotePresentacion(this.value);" required>
                    <option selected disabled value="">------------------------------</option>
                    <?php
                    $InvProdTerminadoOperador = new InvProdTerminadosOperaciones();
                    $presentaciones = $InvProdTerminadoOperador->getProdInv();
                    for ($i = 0; $i < count($presentaciones); $i++) {
                        echo '<option value="' . $presentaciones[$i]['codPresentacion'] . '">' . $presentaciones[$i]['presentacion'] . '</option>';
                    }
                    ?>
                </select>

                <select name="loteProd" id="loteProd" class="form-control col-1" style="margin: 0 5px 0 0;"
                        onchange="findInvLotePresentacion(this.value);" required>
                </select>
                <select name="cantPresentacionAnt" id="cantPresentacionAnt" class="form-control col-1"
                        style="margin: 0 5px 0 0;">
                </select>
                <div class="col-2 text-center" style="padding: 0 20px;">
                    <button class="button" type="button" onclick="return Enviar(this.form)"><span>Continuar</span>
                    </button>
                </div>
            </div>
        </form>
    <?php
    else:
        $DetCambioOperador = new DetCambiosOperaciones();
        $detCambio = $DetCambioOperador->getDetCambio($idCambio);
        ?>
        <div class="row form-group">
            <div class="col-4 text-center" style="margin: 0 5px 0 0;"><strong>Presentación</strong></div>
            <div class="col-1 text-center" style="margin: 0 5px;"><strong>Lote</strong></div>
            <div class="col-1 text-center" style="margin: 0 5px;"><strong>Unidades</strong></div>
        </div>
        <div class="row form-group">
            <div class="col-4 text-center" style="margin: 0 5px 0 0;"><?= $detCambio['presentacion'] ?></div>
            <div class="col-1 text-center" style="margin: 0 5px;"><?= $detCambio['loteProd'] ?></div>
            <div class="col-1 text-center" style="margin: 0 5px;"><?= $detCambio['cantPresentacionAnt'] ?></div>
        </div>
    <?php
    endif;
    ?>
    <div class="form-group titulo row">
        Destino
    </div>
    <?php
    if ($presOrigen == true):
        $volCambiar = $DetCambioOperador->getCantidadPorCambiar($idCambio);
        ?>
        <form method="post" action="makeDetCambio2.php" name="form1">
            <input name="idCambio" type="hidden" value="<?= $idCambio; ?>">
            <div class="row">
                <div class="col-4 text-center" style="margin: 0 5px 0 0;"><strong>Presentación</strong></div>
                <div class="col-1 text-center" style="margin: 0 5px;"><strong>Lote</strong></div>
                <div class="col-1 text-center" style="margin: 0 5px;"><strong>Unidades</strong></div>
                <div class="col-2 text-center">
                </div>
            </div>
            <div class="form-group row">
                <select name="codPresentacionNvo" id="codPresentacionNvo" class="form-control col-4"
                        style="margin: 0 5px 0 0;" required>
                    <option selected disabled value="">------------------------------</option>
                    <?php
                    $presentaciones = $DetCambioOperador->getPresentacionesByCod($detCambio['codPresentacionAnt'], $idCambio, $volCambiar);
                    for ($i = 0; $i < count($presentaciones); $i++) {
                        if ($presentaciones[$i]['codPresentacion'] != $detCambio['codPresentacionAnt']) {
                            echo '<option value="' . $presentaciones[$i]['codPresentacion'] . '">' . $presentaciones[$i]['presentacion'] . '</option>';
                        }
                    }
                    ?>
                </select>

                <input name="loteProd" id="loteProd" class="form-control col-1" style="margin: 0 5px 0 0;"
                       value="<?= $detCambio['loteProd'] ?>"/>
                <input type="text" style="margin: 0 5px 0 0;" class="form-control col-1" name="cantPresentacionNvo"
                       id="cantPresentacionNvo" onKeyPress="return aceptaNum(event)">
                <div class="col-2 text-center" style="padding: 0 20px;">
                    <button class="button" type="button" onclick="return Enviar(this.form)"><span>Continuar</span>
                    </button>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-4 text-right"><strong>Cantidad pendiente por
                        reenvasar: <?= $volCambiar ?> ml</strong></div>
            </div>
        </form>
    <?php
    endif;
    if ($presDestino == true):
        $DetCambioOperador = new DetCambiosOperaciones();
        $detCambio2 = $DetCambioOperador->getDetCambio2($idCambio);
        ?>
        <div class="row form-group">
            <div class="col-4 text-center" style="margin: 0 5px 0 0;"><strong>Presentación</strong></div>
            <div class="col-1 text-center" style="margin: 0 5px;"><strong>Lote</strong></div>
            <div class="col-1 text-center" style="margin: 0 5px;"><strong>Unidades</strong></div>
        </div>
        <?php
        for ($i = 0; $i < count($detCambio2); $i++):
            ?>
            <div class="row form-group">
                <div class="col-4 text-center" style="margin: 0 5px 0 0;"><?= $detCambio2[$i]['presentacion'] ?></div>
                <div class="col-1 text-center" style="margin: 0 5px;"><?= $detCambio2[$i]['loteProd'] ?></div>
                <div class="col-1 text-center"
                     style="margin: 0 5px;"><?= $detCambio2[$i]['cantPresentacionNvo'] ?></div>
            </div>
        <?php
        endfor;
    endif;
    ?>
    <div class="row">
        <div class="col-1">
            <button class="button" id="back" onClick="eliminarSession()"><span>Terminar</span>
            </button>
        </div>
    </div>
</div>
</body>
</html>