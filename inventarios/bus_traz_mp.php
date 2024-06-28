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
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Seleccionar Materia Prima a revisar Trazabilidad</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script>

        function getLotesMPrima(codMPrima) {
            $.ajax({
                url: '../includes/controladorInventarios.php',
                type: 'POST',
                data: {
                    "action": 'findAllLotesMPrima',
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
    </script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>SELECCIÓN DE MATERIA PRIMA A REVISAR TRAZABILIDAD</h4></div>
    <form id="form1" name="form1" method="post" action="traz_mp.php">
        <div class="mb-3 row">
            <label class="form-label col-2" for="codMPrima"><strong>Materia prima</strong></label>
            <select name="codMPrima" id="codMPrima" class="form-select col-2" onchange="getLotesMPrima(this.value)"
                    required>
                <option selected disabled value="">Seleccione una opción--------------</option>
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
        <div class="mb-3 row">
            <label class="form-label col-2" for="loteMP"><strong>Lote</strong></label>
            <select name="loteMP" id="loteMP" class="form-select col-2" required>
            </select>
        </div>
        <div class="mb-3 row">
            <div class="col-1 text-center">
                <button class="button" type="reset"><span>Reiniciar</span></button>
            </div>
            <div class="col-1 text-center">
                <button class="button" type="button" onclick="return Enviar(this.form)"><span>Continuar</span></button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-1">
            <button class="button1" onClick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>
