<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$catsCliOperador = new CategoriasCliOperaciones();
$lastcategorias = $catsCliOperador->getLastCatCli();
$idCategoria = $lastcategorias + 1;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <title>Creación de Tipo de Cliente</title>
    <meta charset="utf-8">
    <script  src="../js/validar.js"></script>

</head>
<body>
<div id="contenedor">
    <div id="saludo"><strong>CREACIÓN DE TIPO DE CLIENTE</strong></div>
    <form name="form2" method="POST" action="makeCategoriaCli.php">
        <div class="form-group row">
            <label class="col-form-label col-1"
                   for="idCatClien"><strong>Código</strong></label>
            <input type="text" class="form-control col-2" name="idCatClien" id="idCatClien" size=30 maxlength="30"
                   value="<?= $idCategoria ?>" readonly>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1"
                   for="desCatClien"><strong>Descripción</strong></label>
            <input type="text" class="form-control col-2" name="desCatClien" id="desCatClien" size=30
                   onKeyPress="return aceptaLetra(event)"
                   maxlength="30" required>
        </div>
        <div class="form-group row">
                        <div class="col-1 text-center" >
                <button class="button" type="reset"><span>Reiniciar</span></button>
            </div><div class="col-1 text-center" >
                <button class="button" onclick="return Enviar(this.form)"><span>Continuar</span></button>
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

