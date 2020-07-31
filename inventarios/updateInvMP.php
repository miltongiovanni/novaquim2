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
$datos = array($invMP, $codMPrima, $loteMP);
$invMPrimasOperador = new InvMPrimasOperaciones();

try {
    $invMPrimasOperador->updateInvMPrima($datos);
    $ruta = "../menu.php";
    $mensaje = "Inventario actualizado correctamente";

} catch (Exception $e) {
    $ruta = "a_inv_mp.php";
    $mensaje = "Error al actualizar el inventario";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}


?>
