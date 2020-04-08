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

$datos = array( $presentacion, $codEnvase, $codTapa, $codEtiq,  $codigoGen, $stockPresentacion, $cotiza, $codPresentacion);
$PresentacionOperador = new PresentacionesOperaciones();

try {
	$PresentacionOperador->updatePresentacion($datos);
	$ruta = "listarmed.php";
	$mensaje =  "Presentación actualizada correctamente";
	
} catch (Exception $e) {
	$ruta = "crearProd.php";
	$mensaje = "Error al actualizar la presentación";
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
?>
