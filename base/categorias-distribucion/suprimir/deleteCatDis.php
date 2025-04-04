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
    <title>Eliminar categoría producto de distribución</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<?php
$idCatDis = $_POST['idCatDis'];
$catsDisOperador = new CategoriasDisOperaciones();
try {
    $catsDisOperador->deleteCatDis($idCatDis);
    $ruta = "../lista/";
    $mensaje = "Categoría producto de distribución eliminada correctamente";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "../suprimir/";
    $mensaje = "Error al eliminar categoría producto de distribución";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>
