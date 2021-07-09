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
    <title>Armado de Kits</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>

</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2"><h4>ARMADO DE KITS DE PRODUCTOS</h4></div>
    <form name="form2" method="POST" action="armado_kits.php">
        <div class="form-group row">
            <label class="col-form-label col-1" for="codKit"><strong>Kit</strong></label>
            <?php
            $KitOperador = new KitsOperaciones();
            $kits = $KitOperador->getKits();
            $filas = count($kits);
            echo '<select name="codKit" id="codKit" class="form-control col-2" required>';
            echo '<option selected disabled value="">-----------------------------</option>';
            for ($i = 0; $i < $filas; $i++) {
                echo '<option value="' . $kits[$i]["idKit"] . '">' . $kits[$i]['producto'] . '</option>';
            }
            echo '</select>';
            ?>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1 text-end" for="cantArmado"><strong>Cantidad</strong></label>
            <input type="text" class="form-control col-2" name="cantArmado" id="cantArmado"
                   onkeydown="return aceptaNum(event)" required>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1 text-end" for="fechArmado"><strong>Fecha</strong></label>
            <input type="date" class="form-control col-2" name="fechArmado" id="fechArmado" required>
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
            <button class="button1" id="back" onClick="window.location='../menu.php'"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>

