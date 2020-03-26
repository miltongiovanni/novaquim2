<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/'.$classname.'.php';
}
spl_autoload_register('cargarClases');
$catsProdOperador = new CategoriasProdOperaciones();
$lastcategorias=$catsProdOperador->getLastCatProd();
$idCategoria=$lastcategorias+1;
?>
<!DOCTYPE html>
<html>

<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <title>Creación de Categoría de Productos</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script type="text/javascript" src="../js/validar.js"></script>
</head>

<body>
    <div id="contenedor">

        <div id="saludo"><strong>CREACIÓN DE CATEGORÍA DE PRODUCTO</strong></div>
        <form name="form2" method="POST" action="makeCategoriaProd.php">
            <div class="form-group row">
                <label class="col-form-label col-1" style="text-align: right;" for="idCatProd"><strong>Código</strong></label>
                <input type="text" class="form-control col-2" name="idCatProd" id="idCatProd" size=30 maxlength="30" value="<?= $idCategoria ?>" readonly >
            </div>
            <div class="form-group row">
                <label class="col-form-label col-1" style="text-align: right;" for="catProd"><strong>Categoría</strong></label>
                <input type="text" class="form-control col-2" name="catProd" id="catProd" size=30 onKeyPress="return aceptaLetra(event)"
                    maxlength="30">
            </div>
            <div class="form-group row">
                <div class="col-1" style="text-align: center;">
                    <button class="button"  onclick="return Enviar(this.form)"><span>Continuar</span></button>
                </div>
                <div class="col-1" style="text-align: center;">
                    <button class="button"  type="reset"><span>Reiniciar</span></button>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-1"><button class="button1" id="back"  onClick="history.back()">
                    <span>VOLVER</span></button></div>
        </div>
    </div>
</body>

</html>