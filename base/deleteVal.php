<?php
	function cargarClases($classname)
	{
		require '../clases/' . $classname . '.php';
	}
	
	spl_autoload_register('cargarClases');
	
	$codTapa = $_POST['codTapa'];
	$TapaOperador = new TapasOperaciones();
	
	
	try {
		$TapaOperador->deleteTapa($codTapa);
		$ruta = "listarVal.php";
		$mensaje =  "Tapa o válvula eliminada correctamente";
		
	} catch (Exception $e) {
		$ruta = "deleteValForm.php";
		$mensaje = "Error al eliminar la tapa o válvula";
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
