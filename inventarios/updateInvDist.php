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
    //echo $nombre_campo." = ".$valor."<br>";
    eval($asignacion);

}
$datos = array($invDistribucion, $codDistribucion);
$invProdDistribucionOperador = new InvDistribucionOperaciones();

try {
    $invProdDistribucionOperador->updateInvDistribucion($datos);
    $ruta = "../menu.php";
    $mensaje = "Inventario actualizado correctamente";

} catch (Exception $e) {
    $ruta = "a_inv_dist.php";
    $mensaje = "Error al actualizar el inventario";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}
?>
