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
    <title>Armado de Kits</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>

</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>ARMADO DE KITS DE PRODUCTOS</h4></div>
    <form name="form2" method="POST" action="armado_kits.php">
        <div class="mb-3 row">
            <div class="col-3">
                <label class="form-label" for="codKit"><strong>Kit</strong></label>
                <?php
                $KitOperador = new KitsOperaciones();
                $kits = $KitOperador->getKits();
                $filas = count($kits);
                echo '<select name="codKit" id="codKit" class="form-select" required>';
                echo '<option selected disabled value="">Seleccione una opción</option>';
                for ($i = 0; $i < $filas; $i++) {
                    echo '<option value="' . $kits[$i]["idKit"] . '">' . $kits[$i]['producto'] . '</option>';
                }
                echo '</select>';
                ?>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-3">
                <label class="form-label" for="cantArmado"><strong>Cantidad</strong></label>
                <input type="text" class="form-control" name="cantArmado" id="cantArmado"
                       onkeydown="return aceptaNum(event)" required>
            </div>
        </div>
        <div class="mb-4 row">
            <div class="col-3">
                <label class="form-label" for="fechArmado"><strong>Fecha</strong></label>
                <input type="date" class="form-control" name="fechArmado" id="fechArmado" required>
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
            <button class="button1" id="back" onClick="window.location='../../../menu.php'"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>

