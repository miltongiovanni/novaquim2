<?php
include "../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if(is_array($valor)){
        //echo $nombre_campo.print_r($valor).'<br>';
    }else{
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}

$fecCambio = Fecha::Hoy();
$intentos = 0;
$datos = array($nombre, $apellido, $usuario, $estadoUsuario, $idPerfil, $fecCambio, $intentos, $idUsuario );
$usuarioOperador = new UsuariosOperaciones();

try {
	$usuarioOperador->updateUser($datos);
	$ruta = "listarUsuarios.php";
	$mensaje =  "Usuario Actualizado correctamente";
	
} catch (Exception $e) {
	$ruta = "buscarUsuario.php";
	$mensaje = "Error al actualizar al usuario";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje);
}


?>
