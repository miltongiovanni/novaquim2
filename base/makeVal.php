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

$TapaOperador = new TapasOperaciones();
$datos = array($codTapa, $tapa,  $stockTapa, $codIva );

try {
	$lastCodTapa=$TapaOperador->makeTapa($datos);
	$ruta = "listarVal.php";
	$mensaje =  "Tapa creada correctamente";
	
} catch (Exception $e) {
	$ruta = "crearVal.php";
	$mensaje = "Error al crear la tapa";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje);
}
	

?>