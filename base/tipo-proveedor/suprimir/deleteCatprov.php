<?php
include "../../../includes/valAcc.php";

// On enregistre notre autoload.
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
    <meta charset="utf-8">
    <title>Eliminar Tipo de Proveedor</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<?php
$idCatProv = $_POST['idCatProv'];
$catsProvOperador = new CategoriasProvOperaciones();
try {
    $catsProvOperador->deleteCatProv($idCatProv);
    $ruta = "../lista/";
    $mensaje = "Categoría de proveedor eliminada correctamente";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "/base/tipo-proveedor/suprimir";
    $mensaje = "Error al eliminar la categoría de proveedor";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>