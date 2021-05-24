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
    <title>Creación cambio de presentación de producto</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor">
    <div id="saludo"><h4>CAMBIO DE PRESENTACIÓN DE PRODUCTO</h4></div>
    <form method="post" action="makeCambio.php" name="form1">
        <div class="form-group row">
            <label class="col-form-label col-2 text-right" for="fechaCambio"><strong>Fecha del cambio</strong></label>
            <input type="date" class="form-control col-2" name="fechaCambio" id="fechaCambio" required>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2" for="codPersonal"><strong>Responsable</strong></label>
            <?php
            $PersonalOperador = new PersonalOperaciones();
            $personal = $PersonalOperador->getPersonalProd();
            echo '<select name="codPersonal" id="codPersonal" class="form-control col-2"  required>';
            echo '<option selected disabled value="">-----------------------------</option>';
            for ($i = 0; $i < count($personal); $i++) {
                echo '<option value="' . $personal[$i]["idPersonal"] . '">' . $personal[$i]['nomPersonal'] . '</option>';
            }
            echo '</select>';
            ?>
        </div>
        <div class="form-group row">
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