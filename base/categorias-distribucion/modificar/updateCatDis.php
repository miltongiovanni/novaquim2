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
    <title>Actualizar datos de Categoría de Distribución</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>

<body>
<?php
$idCatDis = $_POST['idCatDis'];
$catDis = $_POST['catDis'];
$datos = array($catDis, $idCatDis);
$catsDisOperador = new CategoriasDisOperaciones();

try {
    $catsDisOperador->updateCatDis($datos);
    $ruta = "../lista/";
    $mensaje = "Categoría producto de distribución actualizada correctamente";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "../modificar/";
    $mensaje = "Error al actualizar categoría producto de distribución";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}


?>
</body>
</html>