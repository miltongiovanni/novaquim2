<?php
include "../../../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idProv = $_POST['idProv'];
$ProveedorOperador = new ProveedoresOperaciones();
$DetProveedorOperador = new DetProveedoresOperaciones();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Eliminar Proveedor</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
    <script src="../../../js/jquery-3.3.1.min.js"></script>
    <script src="../../../js/findProveedor.js"></script>
</head>


<body>
<?php
try {
    $DetProveedorOperador->deleteAllDetProveedor($idProv);
    $ProveedorOperador->deleteProveedor($idProv);
    $ruta = "listarProv.php";
    $mensaje = "Proveedor borrado correctamente";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "deleteProvForm.php";
    $mensaje = "Error al eliminar el proveedor";
    $icon = "success";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>
