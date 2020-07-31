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
    <meta charset="utf-8">
    <title>Ajuste de Inventario de Tapas o Válvulas</title>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../js/validar.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script>
        function getInvTapa(codTapa) {
            $.ajax({
                url: '../includes/controladorInventarios.php',
                type: 'POST',
                data: {
                    "action": 'findInvTapa',
                    "codTapa": codTapa,
                },
                dataType: 'json',
                success: function (response) {
                    $("#invTapa").val(response);
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
    <div id="saludo"><strong>SELECCIÓN DE TAPA O VÁLVULA A AJUSTAR INVENTARIO</strong></div>
    <form id="form1" name="form1" method="post" action="updateInvTap.php">
        <div class="form-group row">
            <label class="col-form-label col-2" for="codTapa"><strong>Tapa</strong></label>
            <select name="codTapa" id="codTapa" class="form-control col-3 formatoDatos"
                    onchange="getInvTapa(this.value)">
                <option selected disabled value="">-----------------------------</option>
                <?php
                $tapaOperador = new TapasOperaciones();
                $tapas = $tapaOperador->getTapas();
                $filas = count($tapas);
                for ($i = 0; $i < $filas; $i++) {
                    echo '<option value="' . $tapas[$i]["codTapa"] . '">' . $tapas[$i]['tapa'] . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2 text-right"
                   for=invTapa><strong>Inventario</strong></label>
            <input type="text" class="form-control col-3 formatoDatos" name="invTapa" id="invTapa"
                   onKeyPress="return aceptaNum(event)">

        </div>
        <div class="form-group row">
            <div class="col-1 text-center">
                <button class="button" type="reset"><span>Reiniciar</span></button>
            </div>
            <div class="col-1 text-center">
                <button class="button"
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
