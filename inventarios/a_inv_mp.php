<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Ajuste de Inventario de Materia Prima</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script>

        function getLotesMPrima(codMPrima) {
            $.ajax({
                url: '../includes/controladorInventarios.php',
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
                url: '../includes/controladorInventarios.php',
                type: 'POST',
                data: {
                    "action": 'findInvMPrimaXLote',
                    "codMPrima": codMPrima,
                    "loteMP": loteMP,
                },
                dataType: 'json',
                success: function (response) {
                    $("#invMP").val(response);
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
    <div id="saludo"><h4>SELECCIÓN DE MATERIA PRIMA A AJUSTAR INVENTARIO</h4></div>
    <form id="form1" name="form1" method="post" action="updateInvMP.php">
        <div class="form-group row">
            <label class="col-form-label col-2" for="codMPrima"><strong>Materia prima</strong></label>
            <select name="codMPrima" id="codMPrima" class="form-control col-2" onchange="getLotesMPrima(this.value)"
                    required>
                <option selected disabled value="">-----------------------------</option>
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
        <div class="form-group row">
            <label class="col-form-label col-2" for="loteMP"><strong>Lote</strong></label>
            <select name="loteMP" id="loteMP" class="form-control col-2"
                    onchange="getInvMPrimaXLote(document.getElementById('codMPrima').value, this.value)" required>
            </select>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2 text-end"
                   for=invMP><strong>Inventario</strong></label>
            <input type="text" class="form-control col-2" name="invMP" id="invMP" onkeydown="return aceptaNum(event)">

        </div>
        <div class="form-group row">
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
