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
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Eliminar Producto</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>

<body>
<div id="contenedor">
    <div id="saludo"><h4>ELIMINACIÓN DE PRODUCTO</h4></div>
    <form id="form1" name="form1" method="post" action="deleteProd.php">
        <div class="form-group row">
            <label class="col-form-label col-1" for="codProducto"><strong>Producto</strong></label>
            <select name="codProducto" id="codProducto" class="form-control col-2" required>
                <option selected value="">-----------------------------</option>
                <?php
                $ProductoOperador = new ProductosOperaciones();
                $productos = $ProductoOperador->getProductosEliminar();
                for ($i = 0; $i < count($productos); $i++) {
                    echo '<option value="' . $productos[$i]["codProducto"] . '">' . $productos[$i]['nomProducto'] . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="row form-group">
            <div class="col-1">
                <button class="button" type="button" onclick="return Enviar(this.form)">
                    <span>Continuar</span></button>
            </div>
        </div>
    </form>
    <div class="row form-group">
        <div class="col-1">
            <button class="button1" onclick="history.back()">
                <span>VOLVER</span></button>
        </div>
    </div>

</div>
</body>

</html>