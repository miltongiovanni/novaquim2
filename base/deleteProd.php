<?php
include "../includes/valAcc.php";

// On enregistre notre autoload.
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

<?php
$codProducto = $_POST['codProducto'];
$ProductoOperador = new ProductosOperaciones();

try {
    $ProductoOperador->deleteProducto($codProducto);
    $ruta = "listarProd.php";
    $mensaje = "Producto eliminado correctamente";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "../menu.php";
    $mensaje = "No fue permitido eliminar el Producto";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>