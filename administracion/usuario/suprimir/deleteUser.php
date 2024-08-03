<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
	<meta charset="utf-8">
	<title>Borrar Usuario</title>
	<script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
	<script  src="../../../js/validar.js"></script>
</head>


<body>

<?php
	//include "includes/userObj.php";
	$idUsuario=$_POST['idUsuario'];
	$usuarioOperador = new UsuariosOperaciones();

	try {
		$usuarioOperador->deleteUser($idUsuario);
		$ruta = "../lista/";
		$mensaje =  "Usuario borrado correctamente";
		$icon= "success";
	} catch (Exception $e) {
		$ruta = "../suprimir/";
		$mensaje = "Error al borrar al usuario";
		$icon = "error";
	} finally {
		unset($conexion);
		unset($stmt);
		mover_pag($ruta, $mensaje, $icon);
	}


?>
</body>
</html>