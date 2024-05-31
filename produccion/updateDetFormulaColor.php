<?php
include "../../../includes/valAcc.php";
$idFormulaColor = $_POST['idFormulaColor'];
$codMPrima = $_POST['codMPrima'];
$porcentaje = $_POST['porcentaje'];
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar Formulación de Color</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>

</head>
<body>
<?php
$DetFormulaColorOperador = new DetFormulaColorOperaciones();
$datos = array($porcentaje / 100, $idFormulaColor, $codMPrima);
try {
    $DetFormulaColorOperador->updateDetFormulaColor($datos);
    $_SESSION['idFormulaColor'] = $idFormulaColor;
    $ruta = "detFormulaColor.php";
    $mensaje = "Detalle de fórmula de color actualizado con éxito";
    $icon = "success";
} catch (Exception $e) {
    $_SESSION['idFormulaColor'] = $idFormulaColor;
    $ruta = "detFormulaColor.php";
    $mensaje = "Error al actualizar el detalle de la fórmula de color";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>
