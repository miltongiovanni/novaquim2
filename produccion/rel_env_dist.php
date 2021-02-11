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
    <title>Creación de Relación de Materia Prima con Producto de Distribución</title>
    <meta charset="utf-8">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>

</head>
<body>
<div id="contenedor">
    <div id="saludo"><strong>RELACIÓN MATERIA PRIMA CON PRODUCTO DE DISTRIBUCIÓN</strong></div>
    <form name="form2" method="POST" action="make_env_dist.php">

        <div class="form-group row">
            <label class="col-form-label col-2" for="codMPrimaDist"><strong>Materia Prima</strong></label>
            <select name="codMPrimaDist" id="codMPrimaDist" class="form-control col-2" style="margin: 0 5px 0 0;"
                    required>
                <option disabled selected value="">-----------------------------</option>
                <?php
                $envasadoDistOperador = new EnvasadoDistOperaciones();
                $mprimas = $envasadoDistOperador->getMPrimasDist();
                for ($i = 0; $i < count($mprimas); $i++) {
                    echo '<option value="' . $mprimas[$i]["codMPrimaDist"] . '">' . $mprimas[$i]['producto'] . '</option>';
                }
                echo '</select>';
                ?>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2" for="codMedida"><strong>Medida</strong></label>
            <?php
            $MedidasOperador = new MedidasOperaciones();
            $medidas = $MedidasOperador->getMedidas();
            $filas = count($medidas);
            echo '<select name="codMedida" id="codMedida" class="form-control col-2" required>';
            echo '<option selected disabled value="">-----------------------------</option>';
            for ($i = 0; $i < $filas; $i++) {
                echo '<option value="' . $medidas[$i]["idMedida"] . '">' . $medidas[$i]['desMedida'] . '</option>';
            }
            echo '</select>';
            ?>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2" for="codEnvase"><strong>Envase</strong></label>
            <?php
            $EnvasesOperador = new EnvasesOperaciones();
            $envases = $EnvasesOperador->getEnvases();
            $filas = count($envases);
            echo '<select name="codEnvase" id="codEnvase" class="form-control col-2" required>';
            echo '<option selected value="">-----------------------------</option>';
            for ($i = 0; $i < $filas; $i++) {
                echo '<option value="' . $envases[$i]["codEnvase"] . '">' . $envases[$i]['nomEnvase'] . '</option>';
            }
            echo '</select>';
            ?>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2" for="codTapa"><strong>Tapa</strong></label>
            <?php
            $TapasOperador = new TapasOperaciones();
            $tapas = $TapasOperador->getTapas();
            $filas = count($tapas);
            echo '<select name="codTapa" id="codTapa" class="form-control col-2" required>';
            echo '<option selected value="">-----------------------------</option>';
            for ($i = 0; $i < $filas; $i++) {
                echo '<option value="' . $tapas[$i]["codTapa"] . '">' . $tapas[$i]['tapa'] . '</option>';
            }
            echo '</select>';

            ?>

        </div>
        <div class="form-group row">
            <label class="col-form-label col-2" for="codDist"><strong>Producto de Distribución</strong></label>
            <select name="codDist" id="codDist" class="form-control col-2" required>
                <option selected value="">-----------------------------</option>
                <?php
                $EnvasadoDistOperador = new EnvasadoDistOperaciones();
                $productos = $EnvasadoDistOperador->getProdDistxRelMP();
                $filas = count($productos);
                for ($i = 0; $i < $filas; $i++) {
                    echo '<option value="' . $productos[$i]["idDistribucion"] . '">' . $productos[$i]['producto'] . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="form-group row">
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

