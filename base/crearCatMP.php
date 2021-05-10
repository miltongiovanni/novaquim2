<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$catsMPOperador = new CategoriasMPOperaciones();
$lastcategorias = $catsMPOperador->getLastCatMP();
$idCategoria = $lastcategorias + 1;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <title>Creación de Categoría de Materias Primas</title>
    <meta charset="utf-8">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>

</head>

<body>
<div id="contenedor">
    <div id="saludo"><strong>CREACIÓN DE CATEGORÍA DE MATERIA PRIMA</strong></div>
    <form name="form2" method="POST" action="makeCategoriaMP.php">
        <div class="form-group row">
            <label class="col-form-label col-1 text-right" for="idCatMP"><strong>Código</strong></label>
            <input type="text" class="form-control col-2" name="idCatMP" id="idCatMP" size=30 maxlength="30"
                   value="<?= $idCategoria ?>" readonly required>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1 text-right" for="catMP"><strong>Categoría</strong></label>
            <input type="text" class="form-control col-2" name="catMP" id="catMP" size=30
                   onkeydown="return aceptaLetra(event)" maxlength="30" required>
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