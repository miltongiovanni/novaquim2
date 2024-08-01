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
    <title>Eliminar Categoría de Materia Prima</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>

<body>
<?php
$idCatMP = $_POST['idCatMP'];
$catsMPOperador = new CategoriasMPOperaciones();
try {
    $catsMPOperador->deleteCatMP($idCatMP);
    $ruta = "/base/categorias-mprima/lista";
    $mensaje = "Categoría de materia prima eliminada correctamente";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "/base/categorias-mprima/suprimir";
    $mensaje = "Error al eliminar la categoría de materia prima";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}


?>
</body>
</html>