<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idCatProd = $_POST['idCatProd'];
$catsProdOperador = new CategoriasProdOperaciones();
$categoriaProd = $catsProdOperador->getCatProd($idCatProd);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar datos de Categoría</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>

<body>

<div id="contenedor" class="container-fluid">

    <div id="saludo">
        <img src="../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2"><h4>ACTUALIZACIÓN CATEGORÍA DE PRODUCTO</h4></div>
    <form id="form1" name="form1" method="post" action="updateCatProd.php">
        <div class="form-group row">
            <label class="col-form-label col-1 text-end" for="idCatProd"><strong>Código</strong></label>
            <input type="text" class="form-control col-2" name="idCatProd" id="idCatProd" size=30 maxlength="30"
                   value="<?= $categoriaProd['idCatProd']; ?>" readonly>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1 text-end" for="catProd"><strong>Categoría</strong></label>
            <input type="text" class="form-control col-2" name="catProd" id="catProd" size=30
                   onkeydown="return aceptaLetra(event)"
                   value="<?= $categoriaProd['catProd']; ?>" maxlength="30">
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
            <button class="button1" id="back" onClick="history.back()">
                <span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>

</html>