<?php
include "../includes/valAcc.php";
// Función para cargar las clases
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

?>
<!DOCTYPE html>
<html lang="es">
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<head>
    <meta charset="utf-8">
    <title>Seleccionar producto de distribución a consultar</title>
    <script src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor">
    <div id="saludo"><strong>PRODUCTO DE DISTRIBUCIÓN A CONSULTAR</strong></div>
    <form id="form1" name="form1" method="post" action="listacompraxDist.php">
        <div class="form-group row">
            <label class="col-form-label col-1" for="idDistribucion"><strong>Producto</strong></label>
            <select name="idDistribucion" id="idDistribucion" class="form-control col-2">
                <option selected disabled value="">-----------------------------</option>
                <?php
                $ProductoDistribucionOperador = new ProductosDistribucionOperaciones();
                $productos = $ProductoDistribucionOperador->getProductosDistribucion(true);
                $filas = count($productos);
                for ($i = 0; $i < $filas; $i++) {
                    echo '<option value="' . $productos[$i]["idDistribucion"] . '">' . $productos[$i]['producto'] . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="row form-group">
            <div class="col-1">
                <button class="button" onclick="return Enviar(this.form)">
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