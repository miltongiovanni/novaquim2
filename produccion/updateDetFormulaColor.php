<?php
include "../includes/valAcc.php";
$idFormulaColor = $_POST['idFormulaColor'];
$codMPrima = $_POST['codMPrima'];
$porcentaje = $_POST['porcentaje'];
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$DetFormulaColorOperador = new DetFormulaColorOperaciones();
$datos = array( $porcentaje/100, $idFormulaColor, $codMPrima);
try {
    $DetFormulaColorOperador->updateDetFormulaColor($datos);
    $_SESSION['idFormulaColor'] = $idFormulaColor;
    $ruta = "detFormulaColor.php";
    $mensaje = "Detalle de fórmula de color actualizado con éxito";
} catch (Exception $e) {
    $_SESSION['idFormulaColor'] = $idFormulaColor;
    $ruta = "detFormulaColor.php";
    $ruta = $rutaError;
    $mensaje = "Error al actualizar el detalle de la fórmula de color";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}
