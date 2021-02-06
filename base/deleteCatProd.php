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
    <title>Eliminar Categoría de Producto</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>

<body>
<?php
$idCatProd = $_POST['idCatProd'];
$catsProdOperador = new CategoriasProdOperaciones();
try {
    $catsProdOperador->deleteCatProd($idCatProd);
    $ruta = "listarCatProd.php";
    $mensaje = "Categoría de producto eliminada correctamente";
    $icon="success";

} catch (Exception $e) {
    $ruta = "../menu.php";
    $mensaje = "Error al eliminar la categoría de producto";
    $icon="error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>
