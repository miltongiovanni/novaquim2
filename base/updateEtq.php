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
$EtiquetaOperador = new EtiquetasOperaciones();
$datos = array($nomEtiqueta, $stockEtiqueta, $codIva, $codEtiqueta);
try {
	$EtiquetaOperador->updateEtiqueta($datos);
	$ruta = "listarEtq.php";
	$mensaje =  "Etiqueta actualzada correctamente";
	
} catch (Exception $e) {
	$ruta = "buscarEtq.php";
	$mensaje = "Error al actualizar la etiqueta";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje);
}


?>
