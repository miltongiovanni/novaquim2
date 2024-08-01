<?php
include "../../../includes/valAcc.php";
$idFormulaColor = $_POST['idFormulaColor'];
$codMPrima = $_POST['codMPrima'];
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
    <title>Actualizar Formulación de Color</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>

</head>
<body>
<?php
$DetFormulaColorOperador = new DetFormulaColorOperaciones();
$datos = array($idFormulaColor, $codMPrima);
try {
    $DetFormulaColorOperador->deleteDetFormulaColor($datos);
    $_SESSION['idFormulaColor'] = $idFormulaColor;
    $ruta = "../detalle/";
    $mensaje = "Detalle de fórmula de color eliminado con éxito";
    $icon = "success";
} catch (Exception $e) {
    $_SESSION['idFormulaColor'] = $idFormulaColor;
    $ruta = "../detalle/";
    $mensaje = "Error al eliminar el detalle de la fórmula de color";
    $icon = "success";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>

