<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
foreach ($_POST as $nombre_campo => $valor) {
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
    //echo $nombre_campo." = ".$valor."<br>";
    eval($asignacion);
}
$datos = array($codMPrimaDist, $codDist, $codMedida, $codEnvase, $codTapa);
$RelDisMPrimaOperador = new RelDisMPrimaOperaciones();
try {
    $RelDisMPrimaOperador->makeRelEnvDis($datos);
    $ruta = "../menu.php";
    $mensaje = "Relación creada correctamente";

} catch (Exception $e) {
    $ruta = "rel_env_dist.php";
    $mensaje = "Error al crear la relación Distribución - Materia prima";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}


?>




