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

$datos = array($desServicio, $codIva, $activo, $idServicio);
$servicioperador = new ServiciosOperaciones();

try {
	$servicioperador->updateServicio($datos);
	$ruta = "listarServ.php";
	$mensaje = "Servicio actualizado correctamente";

} catch (Exception $e) {
	$ruta = "buscarServ.php";
	$mensaje = "Error al actualizar el Servicio";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje);
}


?>
