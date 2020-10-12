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

$EnvaseOperador = new EnvasesOperaciones();
$datos = array($codEnvase, $nomEnvase,  $stockEnvase, $codIva );

try {
	$lastCodEnvase=$EnvaseOperador->makeEnvase($datos);
	$ruta = "listarEnv.php";
	$mensaje =  "Envase creado correctamente";
	
} catch (Exception $e) {
	$ruta = "crearEnv.php";
	$mensaje = "Error al crear el envase";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje);
}
	

?>




