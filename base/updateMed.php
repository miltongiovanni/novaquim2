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

$datos = array( $presentacion, $codEnvase, $codTapa, $codEtiq,  $codigoGen, $stockPresentacion, $cotiza, $codPresentacion);
$PresentacionOperador = new PresentacionesOperaciones();

try {
	$PresentacionOperador->updatePresentacion($datos);
	$ruta = "listarmed.php";
	$mensaje =  "Presentación actualizada correctamente";
	
} catch (Exception $e) {
	$ruta = "crearProd.php";
	$mensaje = "Error al actualizar la presentación";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje);
}


?>
