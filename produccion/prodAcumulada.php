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
    <title>Consulta de Uso de Materia Prima por Fecha</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor">
    <div id="saludo"><strong>CONSULTA DE PRODUCCION ACUMULADA POR 12 MESES SEGÚN FECHA</strong></div>
    <form method="post" action="listarProdAcumulada.php" name="form1">
        <div class="form-group row">
            <label class="col-form-label col-2 text-right" for="fechRef"><strong>Fecha Referencia</strong></label>
            <input type="date" class="form-control col-2" name="fechRef" id="fechRef" required>
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