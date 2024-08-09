<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$ruteroOperador = new RuteroOperaciones();
$lastRutero = $ruteroOperador->getLastRutero();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Seleccionar Rutero a consultar</title>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>INGRESAR RUTERO A CONSULTAR</h4></div>
    <form id="form1" name="form1" method="post" action="consultaRutero.php">
        <div class="mb-3 row">
            <div class="col-2">
                <label class="form-label" for="idRutero"><strong>No. de Rutero</strong><br>(Último rutero: <?=$lastRutero ?> )</label>
                <input type="text" class="form-control" name="idRutero" id="idRutero" onkeydown="return aceptaNum(event)" required>
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
