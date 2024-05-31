<?php
include "../../../includes/valAcc.php";
// Función para cargar las clases
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Seleccionar producto de distribución a consultar</title>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>PRODUCTO DE DISTRIBUCIÓN A CONSULTAR</h4></div>
    <form id="form1" name="form1" method="post" action="listacompraxDist.php">
        <div class="form-group row">
            <label class="col-form-label col-1" for="idDistribucion"><strong>Producto</strong></label>
            <select name="idDistribucion" id="idDistribucion" class="form-control col-2" required>
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
