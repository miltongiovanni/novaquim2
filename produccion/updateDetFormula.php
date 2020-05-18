<?php
include "../includes/valAcc.php";
$idFormula = $_POST['idFormula'];
$codMPrima = $_POST['codMPrima'];
$porcentaje = $_POST['porcentaje'];
$orden = $_POST['orden'];
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$DetFormulaOperador = new DetFormulaOperaciones();
$datos = array( $porcentaje/100, $orden, $idFormula, $codMPrima);
try {
    $DetFormulaOperador->updateDetFormula($datos);
    $_SESSION['idFormula'] = $idFormula;
    $ruta = "detFormula.php";
    $mensaje = "Detalle de fórmula actualizado con éxito";
} catch (Exception $e) {
    $_SESSION['idFormula'] = $idFormula;
    $ruta = "detFormula.php";
    $ruta = $rutaError;
    $mensaje = "Error al actualizar el detalle de la fórmula";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}
