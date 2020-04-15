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

$datos = array( 0, $codPresentacion);
$PresentacionOperador = new PresentacionesOperaciones();

try {
	$PresentacionOperador->activarDesactivarPresentacion($datos);
	$ruta = "listarmed.php";
	$mensaje =  "Presentación desactivada correctamente";
	
} catch (Exception $e) {
	$ruta = "buscarMed2.php";
	$mensaje = "Error al desactivar la presentación";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje);
}

function mover_pag($ruta,$Mensaje)
{
	echo'<script >
   	alert("'.$Mensaje.'")
   	self.location="'.$ruta.'"
   	</script>';
}
