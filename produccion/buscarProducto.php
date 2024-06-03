<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Seleccionar Producto a revisar Producción</title>
<script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>SELECCIONAR EL PRODUCTO A REVISAR PRODUCCIÓN</h4></div>
    <form id="form1" name="form1" method="post" action="listarEnvasadoProd.php">
        <div class="mb-3 row">
            <label class="form-label col-1" for="codProducto"><strong>Producto</strong></label>
            <?php
            $ProductoOperador = new ProductosOperaciones();
            $productos = $ProductoOperador->getProductos(true);
            $filas = count($productos);
            echo '<select name="codProducto" id="codProducto" class="form-select col-3" required>';
            echo '<option selected disabled value="">-----------------------------</option>';
            for ($i = 0; $i < $filas; $i++) {
                echo '<option value="' . $productos[$i]["codProducto"] . '">' . $productos[$i]['nomProducto'] . '</option>';
            }
            echo '</select>';
            ?>
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
            <button class="button1" onClick="history.back()"><span>VOLVER</span></button>
        </div>
    </div>

</div>
</body>
</html>

