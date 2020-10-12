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
$usuario = strtoupper($_POST['usuario']);
$estadoUsuario = 1;
$fecCambio = Fecha::Hoy();
$fecCrea = Fecha::Hoy();
$intentos = 0;
$clave = md5($usuario);
$datos = array($nombre, $apellido, $usuario, $clave, $estadoUsuario, $idPerfil, $fecCrea, $fecCambio, $intentos);
$usuarioOperador = new UsuariosOperaciones();

try {
	$lastIdUser=$usuarioOperador->makeUser($datos);
	$ruta = "listarUsuarios.php";
	$mensaje =  "Usuario Creado correctamente";
	
} catch (Exception $e) {
	$ruta = "makeUserForm.php";
	$mensaje = "Error al crear el usuario";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje);
}


