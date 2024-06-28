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
    <meta charset="utf-8">
    <title>Seleccionar Producto a Envasar</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>

</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>ENVASADO DE PRODUCTOS DE DISTRIBUCIÓN</h4></div>
    <form id="form1" name="form1" method="post" action="det_env_dist.php">
        <div class="mb-4 row">
            <div class="col-3">
                <label class="form-label" for="codDist"><strong>Producto de Distribución</strong></label>
                <select name="codDist" id="codDist" class="form-select" required>
                    <option selected disabled value="">Seleccione una opción</option>
                    <?php
                    $RelDisMPrimaOperador = new RelDisMPrimaOperaciones();
                    $productos = $RelDisMPrimaOperador->getRelsDisMPrima();
                    $filas = count($productos);
                    for ($i = 0; $i < $filas; $i++) {
                        echo '<option value="' . $productos[$i]["codDist"] . '">' . $productos[$i]['producto'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-2">
                <label class="form-label text-end" for="fechaEnvDist"><strong>Fecha</strong></label>
                <input type="date" class="form-control" name="fechaEnvDist" id="fechaEnvDist" required>
            </div>
            <div class="col-2">
                <label class="form-label text-end" for="cantidad"><strong>Cantidad</strong></label>
                <input type="text" class="form-control" name="cantidad" id="cantidad"
                       onkeydown="return aceptaNum(event)" required>
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
