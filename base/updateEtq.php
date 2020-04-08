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
$EtiquetaOperador = new EtiquetasOperaciones();
$datos = array($nomEtiqueta, $stockEtiqueta, $codIva, $codEtiqueta);
try {
	$EtiquetaOperador->updateEtiqueta($datos);
	$ruta = "listarEtq.php";
	$mensaje =  "Etiqueta actualzada correctamente";
	
} catch (Exception $e) {
	$ruta = "buscarEtq.php";
	$mensaje = "Error al actualizar la etiqueta";
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
