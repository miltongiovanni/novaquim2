<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$catsDisOperador = new CategoriasDisOperaciones();
$lastcategorias = $catsDisOperador->getLastCatDis();
$idCategoria = $lastcategorias + 1;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <title>Creación categorías productos de distribución</title>
    <meta charset="utf-8">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>

<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>CREACIÓN DE CATEGORÍAS DE DISTRIBUCIÓN</h4></div>
    <form name="form2" method="POST" action="makeCategoriaDis.php">
        <div class="mb-3 row">
            <div class="col-1">
                <label class="form-label " for="idCatDis"><strong>Código</strong></label>
                <input type="text" class="form-control " name="idCatDis" id="idCatDis" size=30 maxlength="30"
                       value="<?= $idCategoria ?>" readonly>
            </div>
            <div class="col-3">
                <label class="form-label " for="catDis"><strong>Categoría</strong></label>
                <input type="text" class="form-control " name="catDis" id="catDis" size=30
                       onkeydown="return aceptaLetra(event)" maxlength="30" required>
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
            <button class="button1" id="back" type="button" onClick="history.back()">
                <span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>

</html>