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
$remisionOperador = new RemisionesOperaciones();
$datos = array($cliente, $fechaRemision, $valor, $idRemision);

try {
    $remisionOperador->updateRemision($datos);
    $_SESSION['idRemision'] = $idRemision;
    $ruta = "det_remision.php";
    $mensaje = "Remisión actualizada con éxito";

} catch (Exception $e) {
    $ruta = "buscarRemision.php";
    $mensaje = "Error al actualizar la remisión";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}



?>
