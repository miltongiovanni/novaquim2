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
    <title>Creación cambio de presentación de producto</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>CAMBIO DE PRESENTACIÓN DE PRODUCTO</h4></div>
    <form method="post" action="makeCambio.php" name="form1">
        <div class="mb-3 row">
            <div class="col-2">
                <label class="form-label" for="fechaCambio"><strong>Fecha del cambio</strong></label>
                <input type="date" class="form-control" name="fechaCambio" id="fechaCambio" required>
            </div>
            <div class="col-2">
                <label class="form-label " for="codPersonal"><strong>Responsable</strong></label>
                <?php
                $PersonalOperador = new PersonalOperaciones();
                $personal = $PersonalOperador->getPersonalProd();
                echo '<select name="codPersonal" id="codPersonal" class="form-select"  required>';
                echo '<option selected disabled value="">-----------------------------</option>';
                for ($i = 0; $i < count($personal); $i++) {
                    echo '<option value="' . $personal[$i]["idPersonal"] . '">' . $personal[$i]['nomPersonal'] . '</option>';
                }
                echo '</select>';
                ?>
            </div>

        </div>
        <div class="mb-3 row">
            <div class="col-4">
                <label class="form-label" for=motivo_cambio><strong>Motivo cambio</strong></label>
                <textarea class="form-control" name="motivo_cambio" id="motivo_cambio" required></textarea>
            </div>
        </div>
        <div class="mb-3 row">
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