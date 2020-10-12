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
$TapaOperador = new TapasOperaciones();
$datos = array($tapa, $stockTapa, $codIva, $codTapa);
try {
	$TapaOperador->updateTapa($datos);
	$ruta = "listarVal.php";
	$mensaje =  "Tapa o válvula actualzada correctamente";
	
} catch (Exception $e) {
	$ruta = "buscarVal.php";
	$mensaje = "Error al actualizar la tapa o válvula";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje);
}


?>
