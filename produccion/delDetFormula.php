<?php
include "../includes/valAcc.php";
$idFormula = $_POST['idFormula'];
$codMPrima = $_POST['codMPrima'];
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$DetFormulaOperador = new DetFormulaOperaciones();
$datos = array( $idFormula, $codMPrima);
try {
    $DetFormulaOperador->deleteDetFormula($datos);
    $_SESSION['idFormula'] = $idFormula;
    $ruta = "detFormula.php";
    $mensaje = "Detalle de fórmula eliminado con éxito";
} catch (Exception $e) {
    $_SESSION['idFormula'] = $idFormula;
    $ruta = "detFormula.php";
    $ruta = $rutaError;
    $mensaje = "Error al eliminar el detalle de la fórmula";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}