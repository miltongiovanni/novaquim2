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
	echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}           

$datos = array($codMPrima, $nomMPrima, $aliasMPrima, $idCatMPrima, $minStockMprima, $aparienciaMPrima, $olorMPrima, $colorMPrima, $pHmPrima, $densidadMPrima, $codIva );
$MPrimaOperador = new MPrimasOperaciones();

try {
	$lastCodProducto=$MPrimaOperador->makeMPrima($datos);
	$ruta = "listarMP.php";
	$mensaje =  "Materia prima creada correctamente";
	
} catch (Exception $e) {
	$ruta = "crearMP.php";
	$mensaje = "Error al crear la materia prima";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje);
}

function mover_pag($ruta,$Mensaje){
echo'<script language="Javascript">
   alert("'.$Mensaje.'")
   self.location="'.$ruta.'"
   </script>';
}
?>




