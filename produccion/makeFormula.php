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
$FormulaOperador = new FormulasOperaciones();
$datos = array($nomFormula, $codProducto);
try {
    $idFormula=$FormulaOperador->makeFormula($datos);
    $_SESSION['idFormula'] = $idFormula;
    $ruta = "detFormula.php";
    $mensaje = "Fórmula creada con éxito";
} catch (Exception $e) {
    $ruta = "formula.php";
    $mensaje = "Error al crear la fórmula";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}



