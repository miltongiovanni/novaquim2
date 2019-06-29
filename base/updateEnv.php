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
$EnvaseOperador = new EnvasesOperaciones();
$datos = array($nomEnvase, $stockEnvase, $codIva, $codEnvase);
try {
	$EnvaseOperador->updateEnvase($datos);
	$ruta = "listarEnv.php";
	$mensaje =  "Envase actualzado correctamente";
	
} catch (Exception $e) {
	$ruta = "buscarEnv.php";
	$mensaje = "Error al actualizar el envase";
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
