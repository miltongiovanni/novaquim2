<?php
include "../includes/valAcc.php";
$idFormulaMPrima = $_POST['idFormulaMPrima'];
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');
$FormulaMPrimaOperador = new FormulasMPrimaOperaciones();
try {
    $FormulaMPrimaOperador->deleteFormulaMPrima($idFormulaMPrima);
    $ruta = "../menu.php";
    $mensaje = "Fórmula de materia prima eliminada con éxito";
} catch (Exception $e) {
    $ruta = "deleteFormulaMPrimaForm.php";
    $mensaje = "Error al eliminar la fórmula de materia prima";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
