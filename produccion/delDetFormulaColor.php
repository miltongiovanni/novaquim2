<?php
include "../includes/valAcc.php";
$idFormulaColor = $_POST['idFormulaColor'];
$codMPrima = $_POST['codMPrima'];
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$DetFormulaColorOperador = new DetFormulaColorOperaciones();
$datos = array($idFormulaColor, $codMPrima);
try {
    $DetFormulaColorOperador->deleteDetFormulaColor($datos);
    $_SESSION['idFormulaColor'] = $idFormulaColor;
    $ruta = "detFormulaColor.php";
    $mensaje = "Detalle de fórmula de color eliminado con éxito";
} catch (Exception $e) {
    $_SESSION['idFormulaColor'] = $idFormulaColor;
    $ruta = "detFormulaColor.php";
    $ruta = $rutaError;
    $mensaje = "Error al eliminar el detalle de la fórmula de color";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
