<?php
include "../includes/valAcc.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idServicio = $_POST['idServicio'];
$servicioperador = new ServiciosOperaciones();

try {
    $servicioperador->deleteServicio($idServicio);
    $ruta = "listarServ.php";
    $mensaje = "Servicio eliminado correctamente";

} catch (Exception $e) {
    $ruta = "deleteServForm.php";
    $mensaje = "No fue permitido eliminar el Servicio";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}




?>
