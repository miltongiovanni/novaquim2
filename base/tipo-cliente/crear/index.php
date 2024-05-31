<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$catsCliOperador = new CategoriasCliOperaciones();
$lastcategorias = $catsCliOperador->getLastCatCli();
$idCategoria = $lastcategorias + 1;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <title>Creación de Tipo de Cliente</title>
    <meta charset="utf-8">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>

</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>CREACIÓN DE TIPO DE CLIENTE</h4></div>
    <form name="form2" method="POST" action="makeCategoriaCli.php">
        <div class="form-group row">
            <div class="col-1 text-center">
                <label class="col-form-label " for="idCatClien"><strong>Código</strong></label>
            </div>
            <div class="col-2 px-0">
                <input type="text" class="form-control " name="idCatClien" id="idCatClien" size=30 maxlength="30"
                       value="<?= $idCategoria ?>" readonly>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-1 text-end">
                <label class="col-form-label " for="desCatClien"><strong>Descripción</strong></label>
            </div>
            <div class="col-2 px-0">
                <input type="text" class="form-control " name="desCatClien" id="desCatClien" size=30 onkeydown="return aceptaLetra(event)" maxlength="30" required>
            </div>
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

