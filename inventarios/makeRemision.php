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
    echo $nombre_campo . " = " . $valor . "<br>";
    eval($asignacion);
}

$datos = array($cliente, $fechaRemision, $valor);
$RemisionOperador = new RemisionesOperaciones();

try {
        $lastIdRemision = $RemisionOperador->makeRemision($datos);
        $_SESSION['idRemision'] = $lastIdRemision;
        $ruta = "det_remision.php";
        $mensaje = "Remisión creada con éxito";
} catch (Exception $e) {
    $ruta = "remision.php";
    $mensaje = "Error al crear la remisión";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}



?>
