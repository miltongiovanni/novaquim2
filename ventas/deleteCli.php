<?php
include "../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$idCliente = $_POST['idCliente'];

$clienteOperador = new ClientesOperaciones();

try {
    $clienteOperador->disableCliente($idCliente);
    $ruta = "listarClien.php?estadocliente=0";
    $mensaje = "Cliente desactivado correctamente";

} catch (Exception $e) {
    $ruta = "buscarClien.php";
    $mensaje = "Error al desactivar el cliente";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}

