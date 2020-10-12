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

$datos = array( 1, $codPresentacion);
$PresentacionOperador = new PresentacionesOperaciones();

try {
	$PresentacionOperador->activarDesactivarPresentacion($datos);
	$ruta = "listarmed.php";
	$mensaje =  "Presentación activada correctamente";
	
} catch (Exception $e) {
	$ruta = "buscarMed1.php";
	$mensaje = "Error al activar la presentación";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje);
}


