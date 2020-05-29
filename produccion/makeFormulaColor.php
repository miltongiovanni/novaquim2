<?php
include "../includes/valAcc.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

foreach ($_POST as $nombre_campo => $valor) {
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
    //echo $nombre_campo . " = " . $valor . "<br>";
    eval($asignacion);
}
$FormulaColorOperador = new FormulasColorOperaciones();
$datos = array($codSolucionColor);
try {
    $idFormulaColor=$FormulaColorOperador->makeFormulaColor($datos);
    $_SESSION['idFormulaColor'] = $idFormulaColor;
    $ruta = "detFormulaColor.php";
    $mensaje = "Fórmula de color creada con éxito";
} catch (Exception $e) {
    $ruta = "formula_col.php";
    $mensaje = "Error al crear la fórmula de color";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}



