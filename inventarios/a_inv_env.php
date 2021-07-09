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
    <title>Ajuste de Inventario de Envase</title>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script>
        function getInvEnvase(codEnvase) {
            $.ajax({
                url: '../includes/controladorInventarios.php',
                type: 'POST',
                data: {
                    "action": 'findInvEnvase',
                    "codEnvase": codEnvase,
                },
                dataType: 'json',
                success: function (response) {
                    $("#invEnvase").val(response);
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
        <img src="../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2"><h4>SELECCIÓN DE ENVASE A AJUSTAR INVENTARIO</h4></div>
    <form id="form1" name="form1" method="post" action="updateInvEnv.php">
        <div class="form-group row">
            <label class="col-form-label col-2" for="codEnvase"><strong>Envase</strong></label>
            <select name="codEnvase" id="codEnvase" class="form-control col-3 formatoDatos"
                    onchange="getInvEnvase(this.value)" required>
                <option selected disabled value="">-----------------------------</option>
                <?php
                $envaseOperador = new EnvasesOperaciones();
                $envases = $envaseOperador->getEnvases();
                $filas = count($envases);
                for ($i = 0; $i < $filas; $i++) {
                    echo '<option value="' . $envases[$i]["codEnvase"] . '">' . $envases[$i]['nomEnvase'] . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2 text-end"
                   for=invEnvase><strong>Inventario</strong></label>
            <input type="text" class="form-control col-3 formatoDatos" name="invEnvase" id="invEnvase"
                   onkeydown="return aceptaNum(event)">

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
