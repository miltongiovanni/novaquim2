<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idCatDis = $_POST['idCatDis'];
$catsDisOperador = new CategoriasDisOperaciones();
$categoriaDis = $catsDisOperador->getCatDis($idCatDis);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar datos de Categoría de Distribución</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>

<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2"><h4>ACTUALIZACIÓN CATEGORÍA PRODUCTO DE DISTIRBUCIÓN</h4></div>
    <form id="form1" name="form1" method="post" action="updateCatDis.php">
        <div class="form-group row">
            <label class="col-form-label col-1" for="idCatDis"><strong>Código</strong></label>
            <input type="text" class="form-control col-2" name="idCatDis" id="idCatDis" size=30 maxlength="30"
                   value="<?= $categoriaDis['idCatDis']; ?>" readonly>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1" for="catDis"><strong>Categoría</strong></label>
            <input type="text" class="form-control col-2" name="catDis" id="catDis" size=30
                   onkeydown="return aceptaLetra(event)" value="<?= $categoriaDis['catDis']; ?>" maxlength="30">
        </div>
        <div class="form-group row">
            <div class="col-1 text-center">
                <button class="button" type="reset"><span>Reiniciar</span></button>
            </div>
            <div class="col-1 text-center">
                <button class="button" type="button"
                        onclick="return Enviar(this.form)"><span>Continuar</span></button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-1">
            <button class="button1" id="back" onClick="history.back()">
                <span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>

</html>