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

$datos = array($nitCliente, $nomCliente, $contactoCliente, $cargoCliente, $telCliente, $celCliente, $dirCliente, $emailCliente, $estadoCliente, $idCatCliente, $ciudadCliente, $retIva, $retIca, $retFte, $codVendedor, $exenIva, $idCliente);
$clienteOperador = new ClientesOperaciones();

try {
	$clienteOperador->updateCliente($datos);
	$ruta = "listarClien.php?estadocliente=".$estadoCliente;
	$mensaje = "Cliente actualizado correctamente";

} catch (Exception $e) {
	$ruta = "buscarClien.php";
	$mensaje = "Error al actualizar el cliente";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje);
}
