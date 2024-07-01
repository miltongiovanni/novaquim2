<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Ajuste de Inventario de Materia Prima</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script>

        function getLotesMPrima(codMPrima) {
            $.ajax({
                url: '../../../../includes/controladorInventarios.php',
                type: 'POST',
                data: {
                    "action": 'findLotesMPrima',
                    "codMPrima": codMPrima
                },
                dataType: 'json',
                success: function (lotes) {
                    let rep = '<option selected disabled value="">------------</option>';
                    for (i = 0; i < lotes.length; i++) {
                        rep += '<option value="' + lotes[i].loteMP + '">' + lotes[i].loteMP + '</option>';
                    }
                    $("#loteMP").html(rep);
                },
                error: function () {
                    alert("Vous avez un GROS problème");
                }
            });
        }

        function getInvMPrimaXLote(codMPrima, loteMP) {
            $.ajax({
                url: '../../../../includes/controladorInventarios.php',
                type: 'POST',
                data: {
                    "action": 'findInvMPrimaXLote',
                    "codMPrima": codMPrima,
                    "loteMP": loteMP,
                },
                dataType: 'json',
                success: function (response) {
                    $("#invMP").val(response);
                    $("#inv_ant").val(response);
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
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>SELECCIÓN DE MATERIA PRIMA A AJUSTAR INVENTARIO</h4></div>
    <form id="form1" class="formatoDatos5" name="form1" method="post" action="updateInvMP.php">
        <input type="hidden" name="tipo_inv" value="mp">
        <input type="hidden" name="idResponsable" value="<?= $_SESSION['userId']?>">
        <input type="hidden" name="inv_ant" id="inv_ant" value="">
        <div class="mb-3 row">
            <div class="col-3">
                <label class="form-label" for="codMPrima"><strong>Materia prima</strong></label>
                <select name="codMPrima" id="codMPrima" class="form-select" onchange="getLotesMPrima(this.value)" required>
                    <option selected disabled value="">Seleccione una opción</option>
                    <?php
                    $MPrimaOperador = new MPrimasOperaciones();
                    $mPrimas = $MPrimaOperador->getMPrimas();
                    $filas = count($mPrimas);
                    for ($i = 0; $i < $filas; $i++) {
                        echo '<option value="' . $mPrimas[$i]["codMPrima"] . '">' . $mPrimas[$i]['nomMPrima'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-1 px-0">
                <label class="form-label" for="loteMP"><strong>Lote</strong></label>
                <select name="loteMP" id="loteMP" class="form-select" onchange="getInvMPrimaXLote(document.getElementById('codMPrima').value, this.value)" required>
                </select>
            </div>
            <div class="col-1">
                <label class="form-label  text-end" for=invMP><strong>Inventario</strong></label>
                <input type="text" class="form-control" name="invMP" id="invMP" onkeydown="return aceptaNum(event)">
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-5">
                <label class="form-label" for=motivo_ajuste><strong>Motivo ajuste</strong></label>
                <textarea class="form-control " name="motivo_ajuste" id="motivo_ajuste" required></textarea>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-1 text-center">
                <button class="button" type="reset"><span>Reiniciar</span></button>
            </div>
            <div class="col-1 text-center">
                <button class="button" type="button"
                        onclick="return Enviar(this.form)"><span>Continuar</span></button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-1">
            <button class="button1" id="back" onClick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>
