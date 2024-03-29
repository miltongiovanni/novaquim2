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
    <title>Organización de Kits de Productos de Distribución</title>
    <meta charset="utf-8">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><strong>ORGANIZACIÓN DE KITS DE PRODUCTOS</strong></div>
    <form name="form2" method="POST" action="det_kits.php">
        <div class="form-group row">
            <label class="col-form-label col-1" for="codEnvase"><strong>Kit</strong></label>
            <?php
            $KitOperador = new KitsOperaciones();
            $kits = $KitOperador->getTableKits();
            echo '<select name="idKit" id="idKit" class="form-select col-2" required>';
            echo '<option disabled selected value="">-----------------------------</option>';
            for ($i = 0; $i < count($kits); $i++) {
                echo '<option value="' . $kits[$i]["idKit"] . '">' . $kits[$i]['producto'] . '</option>';
            }
            echo '</select>';
            ?>
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
            <button class="button1" id="back" onClick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>

