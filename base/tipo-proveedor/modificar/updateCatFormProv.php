<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idCatProv = $_POST['idCatProv'];
$catsProvOperador = new CategoriasProvOperaciones();
$categoriaProv = $catsProvOperador->getCatProv($idCatProv);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar datos de Tipo de Proveedor</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>ACTUALIZACIÓN TIPO DE PROVEEDOR</h4></div>

    <form id="form1" name="form1" method="post" action="updateCatProv.php">
        <div class="mb-3 row">
            <div class="col-1">
                <label class="form-label " for="idCatProv"><strong>Código</strong></label>
                <input type="text" class="form-control " name="idCatProv" id="idCatProv" size=30 maxlength="30"
                       value="<?= $categoriaProv['idCatProv']; ?>" readonly>
            </div>
            <div class="col-2">
                <label class="form-label " for="desCatProv"><strong>Descripción</strong></label>
                <input type="text" class="form-control " name="desCatProv" id="desCatProv" size=30
                       onkeydown="return aceptaLetra(event)"
                       value="<?= $categoriaProv['desCatProv']; ?>" maxlength="30">
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
            <button class="button1" id="back" onClick="history.back()">
                <span>VOLVER</span></button>
        </div>
    </div>


</div>
</body>
</html>
