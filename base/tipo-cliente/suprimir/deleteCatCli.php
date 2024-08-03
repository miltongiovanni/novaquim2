<?php
include "../../../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Eliminar Tipo de Cliente</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<?php
spl_autoload_register('cargarClases');

$idCatClien = $_POST['idCatClien'];
$catsCliOperador = new CategoriasCliOperaciones();
try {
    $catsCliOperador->deleteCatCli($idCatClien);
    $ruta = "../lista/";
    $mensaje = "Categoría de cliente eliminada correctamente";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "../suprimir/";
    $mensaje = "Error al eliminar la categoría de cliente";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>
