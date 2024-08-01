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
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <link href="../../../node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Eliminar Producto</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../node_modules/select2/dist/js/select2.min.js"></script>
    <script src="../../../node_modules/select2/dist/js/i18n/es.js"></script>
    <script>
        $(document).ready(function () {
            $('#codProducto').select2({
                placeholder: 'Seleccione un producto',
                language: "es"
            });
        });
    </script>
</head>

<body>
<div id="contenedor" class="container-fluid">
    <div id="saludo">
        <img src="../../../images/LogoNova1.jpg" alt="novaquim" class="img-fluid mb-2 w-25"><h4>ELIMINACIÓN DE PRODUCTO</h4></div>
    <form id="form1" name="form1" method="post" action="deleteProd.php">
        <div class="mb-3 row">
            <div class="col-2">
                <label class="form-label" for="codProducto"><strong>Producto</strong></label>
                <select name="codProducto" id="codProducto" class="form-select" required>
                    <option></option>
                    <?php
                    $ProductoOperador = new ProductosOperaciones();
                    $productos = $ProductoOperador->getProductosEliminar();
                    for ($i = 0; $i < count($productos); $i++) {
                        echo '<option value="' . $productos[$i]["codProducto"] . '">' . $productos[$i]['nomProducto'] . '</option>';
                    }
                    ?>
                </select>
            </div>

        </div>
        <div class="row mb-3">
            <div class="col-1">
                <button class="button" type="button" onclick="return Enviar(this.form)">
                    <span>Continuar</span></button>
            </div>
        </div>
    </form>
    <div class="row mb-3">
        <div class="col-1">
            <button class="button1" onclick="history.back()">
                <span>VOLVER</span></button>
        </div>
    </div>

</div>
</body>

</html>