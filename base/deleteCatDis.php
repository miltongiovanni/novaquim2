<?php
include "../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$idCatDis=$_POST['idCatDis'];
$catsDisOperador = new CategoriasDisOperaciones();
try {
	$catsDisOperador->deleteCatDis($idCatDis);
	$ruta = "listarCatDis.php";
	$mensaje =  "Categoría producto de distribución eliminada correctamente";
	
} catch (Exception $e) {
	$ruta = "../menu.php";
	$mensaje = "Error al eliminar categoría producto de distribución";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje);
}

function mover_pag($ruta,$nota)
	{
	echo'<script language="Javascript">
	alert("'.$nota.'")
	self.location="'.$ruta.'"
	</script>';
	}
?>