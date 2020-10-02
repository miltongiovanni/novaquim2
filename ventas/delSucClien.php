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

$clienteSucursalOperador = new ClientesSucursalOperaciones();
$datos = array($idCliente, $idSucursal);

try {
    $clienteSucursalOperador->deleteClienteSucursal($datos);
    $_SESSION['idCliente'] = $idCliente;
    $ruta = "detCliente.php";
    $mensaje = "Sucursal eliminada correctamente";

} catch (Exception $e) {
    $_SESSION['idCliente'] = $idCliente;
    $ruta = "detCliente.php";
    $mensaje = "Error al eliminar la sucursal";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}
