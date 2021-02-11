<?php
include "../includes/valAcc.php";
$idFormulaMPrima = $_POST['idFormulaMPrima'];
$codMPrima = $_POST['codMPrima'];
$porcentaje = $_POST['porcentaje'];
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
    <title>Actualizar Formulación de MPrima</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>

</head>
<body>
<?php
$DetFormulaMPrimaOperador = new DetFormulaMPrimaOperaciones();
$datos = array($porcentaje / 100, $idFormulaMPrima, $codMPrima);
try {
    $DetFormulaMPrimaOperador->updateDetFormulaMPrima($datos);
    $_SESSION['idFormulaMPrima'] = $idFormulaMPrima;
    $ruta = "detFormulaMPrima.php";
    $mensaje = "Detalle de fórmula de materia prima actualizado con éxito";
    $icon = "success";
} catch (Exception $e) {
    $_SESSION['idFormulaMPrima'] = $idFormulaMPrima;
    $ruta = "detFormulaMPrima.php";
    $mensaje = "Error al actualizar el detalle de la fórmula de materia prima";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>
