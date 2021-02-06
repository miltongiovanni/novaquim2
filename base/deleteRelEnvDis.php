<?php
include "../includes/valAcc.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idEnvDis = $_POST['idEnvDis'];
$relEnvDisOperador = new RelEnvDisOperaciones();
?>
<!DOCTYPE html>
<html lang="es">
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
<head>
    <meta charset="utf-8">
    <title>Seleccionar Relación Envase Producto de Distribución a Eliminar</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>

<?php
try {
    $relEnvDisOperador->deleteRelEnvDis($idEnvDis);
    $ruta = "listarenvaseDis.php";
    $mensaje = "Relación Envase Producto de Distribución eliminada correctamente";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "buscarRelEnvDis.php";
    $mensaje = "No fue permitido eliminar la relación Envase Producto de Distribución";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>