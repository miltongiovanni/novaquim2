<?php
include "../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
	require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		//echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	}

$datos = array($desServicio, $codIva, $activo, $idServicio);
$servicioperador = new ServiciosOperaciones();

try {
	$servicioperador->updateServicio($datos);
	$ruta = "listarServ.php";
	$mensaje = "Servicio actualizado correctamente";

} catch (Exception $e) {
	$ruta = "buscarServ.php";
	$mensaje = "Error al actualizar el Servicio";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje);
}

function mover_pag($ruta,$Mensaje)
{
	echo'<script language="Javascript">
   	alert("'.$Mensaje.'")
   	self.location="'.$ruta.'"
   	</script>';
}
?>
