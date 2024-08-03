<?php
include "../../../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$idCatProd = $_POST['idCatProd'];
$catProd = $_POST['catProd'];
$datos = array($catProd, $idCatProd);
$catsProdOperador = new CategoriasProdOperaciones();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar datos de Categoría</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>

<body>
<?php
try {
    $catsProdOperador->updateCatProd($datos);
    $ruta = "../lista/";
    $mensaje = "Categoría de producto actualizada correctamente";
    $icon = "success";

} catch (Exception $e) {
    $ruta = "../modificar/";
    $mensaje = "Error al actualizar la categoría de producto";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>