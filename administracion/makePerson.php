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

$datos = array($nomPersonal, $activoPersonal, $areaPersonal, $celPersonal, $emlPersonal, $cargoPersonal);
$personalOperador = new PersonalOperaciones();

try {
	$lastIdPersonal=$personalOperador->makePersonal($datos);
	$ruta = "listarPersonal.php";
	$mensaje =  "Personal Creado correctamente";
	
} catch (Exception $e) {
	$ruta = "makePersonalForm.php";
	$mensaje = "Error al crear el personal";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje);
}


function mover_pag($ruta,$Mensaje){
echo'<script >
   alert("'.$Mensaje.'")
   self.location="'.$ruta.'"
   </script>';
}

?>
