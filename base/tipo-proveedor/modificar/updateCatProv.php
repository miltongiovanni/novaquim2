<?php
include "../../../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$idCatProv = $_POST['idCatProv'];
$desCatProv = $_POST['desCatProv'];
$datos = array($desCatProv, $idCatProv);
$catsProvOperador = new CategoriasProvOperaciones();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar datos de Tipo de Proveedor</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<?php
try {
    $catsProvOperador->updateCatProv($datos);
    $ruta = "../lista/";
    $mensaje = "Categoría de proveedor actualizada correctamente";
    $icon = "success";

} catch (Exception $e) {
    $ruta = "../modificar/";
    $mensaje = "Error al actualizar la categoría de proveedor";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>