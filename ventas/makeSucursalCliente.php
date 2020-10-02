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
$idSucursal = $clienteSucursalOperador->getMaxSucursalByIdCliente($idCliente) + 1;
$datos = array($idCliente, $idSucursal, $dirSucursal, $ciudadSucursal, $telSucursal, $nomSucursal);
try {
    $lastIdCliente = $clienteSucursalOperador->makeClienteSucursal($datos);
    $_SESSION['idCliente'] = $idCliente;
    $ruta = "detCliente.php";
    $mensaje = "Sucursal del cliente creada con éxito";

} catch (Exception $e) {
    $ruta = "makeClienForm.php";
    $mensaje = "Error al crear la sucursal del Cliente";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}



