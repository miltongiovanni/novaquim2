<?php
	include "../includes/valAcc.php";
	function cargarClases($classname)
	{
		require '../clases/' . $classname . '.php';
	}
	
	spl_autoload_register('cargarClases');
	$idPersonal=$_POST['idPersonal'];
	$personalOperador = new PersonalOperaciones();

	try {
		$personalOperador->deletePersonal($idPersonal);
		$ruta = "listarPersonal.php";
		$mensaje =  "Personal borrado correctamente";
		
	} catch (Exception $e) {
		$ruta = "../menu.php";
		$mensaje = "Error al borrar al personal";
	} finally {
		unset($conexion);
		unset($stmt);
		mover_pag($ruta, $mensaje);
	}

function mover_pag($ruta,$nota)
	{
	echo'<script >
	alert("'.$nota.'")
	self.location="'.$ruta.'"
	</script>';
	}
?>