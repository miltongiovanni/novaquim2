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
$distribuidor= (round($fabrica*2*1.12,-2))/2;
$detal= (round($fabrica*2*1.4,-2))/2;
$mayor= (round($distribuidor*2*0.93,-2))/2;
$super= (round($fabrica*2*0.93,-2))/2;
$PrecioOperador = new PreciosOperaciones();
$datos = array($producto, $fabrica, $distribuidor, $detal, $mayor, $super, $presActiva, $presLista, $codigoGen );


try {
	$PrecioOperador->updatePrecio($datos);
	$ruta = "listarCod.php";
	$mensaje =  "Código genérico actualizado correctamente";
	
} catch (Exception $e) {
	$ruta = "buscarCod.php";
	$mensaje = "Error al actualizar el código genérico";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje);
}

?>
