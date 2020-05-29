<?php
include "../includes/valAcc.php";
$idFormulaColor = $_POST['idFormulaColor'];
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');
$FormulaColorOperador = new FormulasColorOperaciones();
try {
    $FormulaColorOperador->deleteFormulaColor($idFormulaColor);
    $ruta = "../menu.php";
    $mensaje = "Fórmula de color eliminada con éxito";
} catch (Exception $e) {
    $ruta = "deleteFormulaColorForm.php";
    $mensaje = "Error al eliminar la fórmula de color";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}
