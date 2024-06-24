<?php
include "../../../includes/valAcc.php";
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
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$cambioOperador = new CambiosOperaciones();
$cambio = $cambioOperador->getCambio($idCambio);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Cambio de presentación de Producto</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script>
        function redireccion() {
            window.location.href = "../../../menu.php";
        }

        function eliminarSession() {
            let variables = 'idCambio,presOrigen,presDestino';
            $.ajax({
                url: '../../../includes/controladorProduccion.php',
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
                url: '../../../includes/controladorProduccion.php',
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
                url: '../../../includes/controladorProduccion.php',
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
<div id="contenedor" class="container-fluid">
    <div id="saludo1">
        <img src="../../../images/LogoNova.jpg" alt="novaquim" class="img-fluid mb-2">
        <h4>CAMBIO DE PRESENTACIÓN DE PRODUCTO</h4>
    </div>
    <div class="mb-3 row formatoDatos5">
        <div class="col-1">
            <strong>Cambio</strong>
            <div class="bg-blue"><?= $idCambio; ?></div>
        </div>
        <div class="col-2">
            <strong>Fecha de cambio</strong>
            <div class="bg-blue"><?= $cambio['fechaCambio'] ?></div>
        </div>
        <div class="col-2">
            <strong>Responsable</strong>
            <div class="bg-blue"><?= $cambio['nomPersonal'] ?></div>
        </div>
    </div>
    <div class="mb-3 titulo row text-center">
        Origen
    </div>
    <?php
    if ($presOrigen == false):
        ?>
        <form method="post" class="formatoDatos5" action="makeDetCambio.php" name="form1">
            <input name="idCambio" type="hidden" value="<?= $idCambio; ?>">
            <div class="row">
                <div class="col-4">
                    <label class="form-label" for="codPresentacionAnt"><strong>Presentación</strong></label>
                    <select name="codPresentacionAnt" id="codPresentacionAnt" class="form-select" onchange="findLotePresentacion(this.value);" required>
                        <option selected disabled value="">------------------------------</option>
                        <?php
                        $InvProdTerminadoOperador = new InvProdTerminadosOperaciones();
                        $presentaciones = $InvProdTerminadoOperador->getProdInv();
                        for ($i = 0; $i < count($presentaciones); $i++) {
                            echo '<option value="' . $presentaciones[$i]['codPresentacion'] . '">' . $presentaciones[$i]['presentacion'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-1">
                    <label class="form-label" for="loteProd"><strong>Lote</strong></label>
                    <select name="loteProd" id="loteProd" class="form-select" onchange="findInvLotePresentacion(this.value);" required>
                    </select>
                </div>
                <div class="col-1">
                    <label class="form-label" for="cantPresentacionAnt"><strong>Unidades</strong></label>
                    <select name="cantPresentacionAnt" id="cantPresentacionAnt" class="form-select col-1" >
                    </select>
                </div>
                <div class="col-2 pt-3">
                    <button class="button mt-2" type="button" onclick="return Enviar(this.form)"><span>Continuar</span></button>
                </div>
            </div>
            <div class="mb-3 row">

                <div class="col-2 text-center" style="padding: 0 20px;">
                </div>
            </div>
        </form>
    <?php
    else:
        $DetCambioOperador = new DetCambiosOperaciones();
        $detCambio = $DetCambioOperador->getDetCambio($idCambio);
        ?>
        <div class="row mb-3 formatoDatos5">
            <div class="col-3 text-center">
                <strong>Presentación</strong>
                <div><?= $detCambio['presentacion'] ?></div>
            </div>
            <div class="col-1 text-center">
                <strong>Lote</strong>
                <div><?= $detCambio['loteProd'] ?></div>
            </div>
            <div class="col-1 text-center">
                <strong>Unidades</strong>
                <div><?= $detCambio['cantPresentacionAnt'] ?></div>
            </div>
        </div>

    <?php
    endif;
    ?>
    <div class="mb-3 titulo row text-center">
        Destino
    </div>
    <?php
    if ($presOrigen == true):
        $volCambiar = $DetCambioOperador->getCantidadPorCambiar($idCambio);
        ?>
        <form method="post" class="formatoDatos5" action="makeDetCambio2.php" name="form1">
            <input name="idCambio" type="hidden" value="<?= $idCambio; ?>">
            <div class="row mb-3">
                <div class="col-3">
                    <label class="form-label" for="codPresentacionNvo"><strong>Presentación</strong></label>
                    <select name="codPresentacionNvo" id="codPresentacionNvo" class="form-select" required>
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
                </div>
                <div class="col-1">
                    <label class="form-label" for="loteProd"><strong>Lote</strong></label>
                    <input name="loteProd" id="loteProd" class="form-control"  value="<?= $detCambio['loteProd'] ?>"/>
                </div>
                <div class="col-1">
                    <label class="form-label" for="cantPresentacionNvo"><strong>Unidades</strong></label>
                    <input type="text" class="form-control" name="cantPresentacionNvo" id="cantPresentacionNvo" onkeydown="return aceptaNum(event)">
                </div>
                <div class="col-2 pt-3">
                    <button class="button mt-2" type="button" onclick="return Enviar(this.form)"><span>Continuar</span>
                    </button>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-3 text-end"><strong>Cantidad pendiente por reenvasar: <?= $volCambiar ?> ml</strong></div>
            </div>
        </form>
    <?php
    endif;
    if ($presDestino == true):
        $DetCambioOperador = new DetCambiosOperaciones();
        $detCambio2 = $DetCambioOperador->getDetCambio2($idCambio);
        ?>
        <div class="row mb-3 formatoDatos5">
            <div class="col-3 text-center">
                <strong>Presentación</strong>
            </div>
            <div class="col-1 text-center">
                <strong>Lote</strong>
            </div>
            <div class="col-1 text-center">
                <strong>Unidades</strong>
            </div>
        </div>
        <?php
        for ($i = 0; $i < count($detCambio2); $i++):
            ?>
            <div class="row mb-3 formatoDatos5">
                <div class="col-3 text-center"><?= $detCambio2[$i]['presentacion'] ?></div>
                <div class="col-1 text-center"><?= $detCambio2[$i]['loteProd'] ?></div>
                <div class="col-1 text-center"><?= $detCambio2[$i]['cantPresentacionNvo'] ?></div>
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