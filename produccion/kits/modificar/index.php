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
    <title>Organización de Kits de Productos de Distribución</title>
    <meta charset="utf-8">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>ORGANIZACIÓN DE KITS DE PRODUCTOS</h4>
    </div>
    <form name="form2" method="POST" action="../detalle/">
        <div class="mb-3 row">
            <div class="col-4">
                <label class="form-label" for="codEnvase"><strong>Kit</strong></label>
                <?php
                $KitOperador = new KitsOperaciones();
                $kits = $KitOperador->getTableKits();
                echo '<select name="idKit" id="idKit" class="form-select" required>';
                echo '<option disabled selected value="">Seleccione una opción</option>';
                for ($i = 0; $i < count($kits); $i++) {
                    echo '<option value="' . $kits[$i]["idKit"] . '">' . $kits[$i]['producto'] . '</option>';
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

