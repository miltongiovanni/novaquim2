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
    <title>Actualizar datos Categoría Materias Primas</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<?php
$idCatMP = $_POST['idCatMP'];
$catMP = $_POST['catMP'];
$datos = array($catMP, $idCatMP);
$catsMPOperador = new CategoriasMPOperaciones();

try {
    $catsMPOperador->updateCatMP($datos);
    $ruta = "listarCatMP.php";
    $mensaje = "Categoría de materia prima actualizada correctamente";
	$icon = "success";
} catch (Exception $e) {
    $ruta = "buscarCatMP.php";
    $mensaje = "Error al actualizar la categoría de materia prima";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>