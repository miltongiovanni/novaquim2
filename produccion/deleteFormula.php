<?php
include "../includes/valAcc.php";
$idFormula = $_POST['idFormula'];
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');
$FormulaOperador = new FormulasOperaciones();
try {
    $FormulaOperador->deleteFormula($idFormula);
    $_SESSION['idFormula'] = $idFormula;
    $ruta = "../menu.php";
    $mensaje = "Fórmula eliminada con éxito";
} catch (Exception $e) {
    $ruta = "deleteFormulaForm.php";
    $mensaje = "Error al eliminar la fórmula";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
