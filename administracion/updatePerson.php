<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
?>
<?php


foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  

$datos = array($nomPersonal, $activoPersonal, $areaPersonal, $celPersonal, $emlPersonal, $cargoPersonal, $idPersonal );
$personalOperador = new PersonalOperaciones();

try {
	$personalOperador->updatePersonal($datos);
	$ruta = "listarPersonal.php";
	$mensaje =  "Personal Actualizado correctamente";
	
} catch (Exception $e) {
	$ruta = "buscarPersonal.php";
	$mensaje = "Error al actualizar al Personal";
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
