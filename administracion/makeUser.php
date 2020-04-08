<?php
include "../includes/valAcc.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

foreach ($_POST as $nombre_campo => $valor) {
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
    //echo $nombre_campo." = ".$valor."<br>";
    eval($asignacion);
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

function mover_pag($ruta, $mensaje)
{
    echo '<script >
   alert("' . $mensaje . '")
   self.location="' . $ruta . '"
   </script>';
}
