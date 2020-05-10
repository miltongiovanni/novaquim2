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
$datos = array($codEtiqueta, $nomEtiqueta,  $stockEtiqueta, $codIva );

try {
	$lastCodEtiqueta=$EtiquetaOperador->makeEtiqueta($datos);
	$ruta = "listarEtq.php";
	$mensaje =  "Etiqueta creada correctamente";
	
} catch (Exception $e) {
	$ruta = "crearEtq.php";
	$mensaje = "Error al crear la etiqueta";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje);
}
	

?>




