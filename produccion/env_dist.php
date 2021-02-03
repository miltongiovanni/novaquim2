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
    <meta charset="utf-8">
    <title>Seleccionar Producto a Envasar</title>
<script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>

</head>
<body>
<div id="contenedor">
    <div id="saludo"><strong>ENVASADO DE PRODUCTOS DE DISTRIBUCIÓN</strong></div>
    <form id="form1" name="form1" method="post" action="det_env_dist.php">
        <div class="form-group row">
            <label class="col-form-label col-2" for="codDist"><strong>Producto de Distribución</strong></label>
            <select name="codDist" id="codDist" class="form-control col-2" required>
                <option selected value="">-----------------------------</option>
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
        <div class="form-group row">
            <label class="col-form-label col-2 text-right" for="fechaEnvDist"><strong>Fecha</strong></label>
            <input type="date" class="form-control col-2" name="fechaEnvDist" id="fechaEnvDist" required>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2 text-right" for="cantidad"><strong>Cantidad</strong></label>
            <input type="text" class="form-control col-2" name="cantidad" id="cantidad"
                   onKeyPress="return aceptaNum(event)" required>
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
