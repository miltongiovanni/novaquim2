<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

	//include "includes/userObj.php";
	$idUsuario=$_POST['idUsuario'];
	$usuarioOperador = new UsuariosOperaciones();

	try {
		$usuarioOperador->deleteUser($idUsuario);
		$ruta = "listarUsuarios.php";
		$mensaje =  "Usuario borrado correctamente";
		
	} catch (Exception $e) {
		$ruta = "../menu.php";
		$mensaje = "Error al borrar al usuario";
	} finally {
		unset($conexion);
		unset($stmt);
		mover_pag($ruta, $mensaje);
	}


?>
