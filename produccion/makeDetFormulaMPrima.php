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
$DetFormulaMPrimaOperador = new DetFormulaMPrimaOperaciones();
$datos = array($idFormulaMPrima, $codMPrima, $porcentaje/100);
try {
    $DetFormulaMPrimaOperador->makeDetFormulaMPrima($datos);
    $_SESSION['idFormulaMPrima'] = $idFormulaMPrima;
    $ruta = "detFormulaMPrima.php";
    $mensaje = "Detalle de fórmula de materia prima adicionado con éxito";
} catch (Exception $e) {
    $_SESSION['idFormulaMPrima'] = $idFormulaMPrima;
    $ruta = "detFormulaMPrima.php";
    $ruta = $rutaError;
    $mensaje = "Error al ingresar el detalle de la fórmula de materia prima";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}



