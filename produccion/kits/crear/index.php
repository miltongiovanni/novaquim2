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
    <title>Creación de Kits de Productos de Distribución</title>
    <meta charset="utf-8">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script>

        //var idCatProd = $('idCatProd').value;

        function seleccionarTipo(tipo) {
            //alert(idCatProd);
            $.ajax({
                url: '../../../includes/controladorProduccion.php',
                type: 'POST',
                data: {
                    "action": 'selectionarTipoKit',
                    "tipo": tipo
                },
                dataType: 'html',
                success: function (kitTipo) {
                    document.getElementById("tipoKit").innerHTML = kitTipo;
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
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25">
        <h4>SELECCIONE EL TIPO DE KIT A CREAR</h4>
    </div>
    <form name="form2" method="POST" action="make_kits.php">
        <div class="mb-3 row">
            <div class="col-2">
                <label class="form-label" for="tipo"><strong>Tipo de kit</strong></label>
                <select name="tipo" id="tipo" class="form-select" onchange="seleccionarTipo(this.value);" required>
                    <option disabled selected value="">Seleccione una opción</option>
                    <option value=1>Kit Novaquim</option>
                    <option value=2>Kit Distribución</option>
                </select>
            </div>
        </div>
        <div class="mb-3 row" id="tipoKit">
        </div>
        <div class="mb-3 row">
            <div class="col-2">
                <label class="form-label" for="codEnvase"><strong>Envase</strong></label>
                <?php
                $EnvasesOperador = new EnvasesOperaciones();
                $envases = $EnvasesOperador->getEnvases();
                $filas = count($envases);
                echo '<select name="codEnvase" id="codEnvase" class="form-select" required>';
                echo '<option disabled selected value="">Seleccione una opción</option>';
                for ($i = 0; $i < $filas; $i++) {
                    echo '<option value="' . $envases[$i]["codEnvase"] . '">' . $envases[$i]['nomEnvase'] . '</option>';
                }
                echo '</select>';
                ?>
            </div>
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
            <button class="button1" id="back" onClick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>

