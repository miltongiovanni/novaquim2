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
$datos = array($idDis, $idEnv, $idTapa);
$relEnvDisoperador = new RelEnvDisOperaciones();

try {
	$relDis = $relEnvDisoperador->checkDistribucion($idDis);
	if ( $relDis['idEnvDis']  != null ){
		$_SESSION['idEnvDis'] = $relDis['idEnvDis'];
		header('Location: updateRelEnvDisForm.php');
	}
	else{
		$lastCodRelEnvDis=$relEnvDisoperador->makeRelEnvDis($datos);
		$ruta = "listarenvaseDis.php";
		$mensaje =  "Relación creada con Éxito";
	}


} catch (Exception $e) {
	$ruta = "envaseDis.php";
	$mensaje = "Error al crear la relación";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje);
}




function enviar_mensaje($mensaje){
	echo'<script >
   alert("'.$mensaje.'");
   </script>';
}

?>
