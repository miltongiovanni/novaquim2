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
$datos = array($codPaca, $codUnidad, $cantidad);
$relDisEmpOperador = new RelDisEmpOperaciones();

try {
	$relDes = $relDisEmpOperador->checkPaca($codPaca);
	if ( $relDes['idPacUn']  != null ){
		$_SESSION['idPacUn'] = $relDes['idPacUn'];
		header('Location: updateRelPacProdForm.php');
	}
	else{
		$lastCodRelEnvDis=$relDisEmpOperador->makeRelDisEmp($datos);
		$ruta = "listarDes.php";
		$mensaje =  "Relación creada con Éxito";
	}

} catch (Exception $e) {
	$ruta = "crearDes.php";
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
