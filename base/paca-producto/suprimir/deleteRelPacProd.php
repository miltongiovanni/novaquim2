<?php
include "../../../includes/valAcc.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idPacUn = $_POST['idPacUn'];
$relDisEmpOperador = new RelDisEmpOperaciones();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">

    <meta charset="utf-8">
    <title>Seleccionar Relación Paca Unidad Producto de Distribución a Eliminar</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<?php
try {
    $relDisEmpOperador->deleteRelDisEmp($idPacUn);
    $ruta = "/base/paca-producto/lista";
    $mensaje = "Relación paca unidad producto de distribución eliminada correctamente";
    $icon = "success";

} catch (Exception $e) {
    $ruta = "/base/paca-producto/suprimir";
    $mensaje = "No fue permitido eliminar la relación paca unidad producto de distribución";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>