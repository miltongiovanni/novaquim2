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
$DetFormulaColorOperador = new DetFormulaColorOperaciones();
$datos = array($idFormulaColor, $codMPrima, $porcentaje/100);
try {
    $DetFormulaColorOperador->makeDetFormulaColor($datos);
    $_SESSION['idFormulaColor'] = $idFormulaColor;
    $ruta = "detFormulaColor.php";
    $mensaje = "Detalle de fórmula de color adicionado con éxito";
} catch (Exception $e) {
    $_SESSION['idFormulaColor'] = $idFormulaColor;
    $ruta = "detFormulaColor.php";
    $ruta = $rutaError;
    $mensaje = "Error al ingresar el detalle de la fórmula de color";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}



