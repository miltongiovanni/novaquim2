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
    <title>Ingreso de Fórmulas de Producto</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo"><h4>INGRESO DE FÓRMULAS DE PRODUCTO</h4></div>
    <form method="post" action="makeFormula.php" name="form1">
        <div class="form-group row">
            <label class="col-form-label col-1" for="codProducto"><strong>Producto</strong></label>
            <?php
            $ProductoOperador = new ProductosOperaciones();
            $productos = $ProductoOperador->getProductos(true);
            $filas = count($productos);
            echo '<select name="codProducto" id="codProducto" class="form-control col-3" required>';
            echo '<option selected disabled value="">-----------------------------</option>';
            for ($i = 0; $i < $filas; $i++) {
                echo '<option value="' . $productos[$i]["codProducto"] . '">' . $productos[$i]['nomProducto'] . '</option>';
            }
            echo '</select>';
            ?>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-1" for="nomFormula"><strong>Fórmula</strong></label>
            <input name="nomFormula" id="nomFormula" class="form-control col-3" type="text" value="" required/>
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
            <button class="button1" onClick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>
</div>
</body>
</html>