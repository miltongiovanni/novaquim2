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

$datos = array($nomMPrima, $aliasMPrima, $idCatMPrima, $minStockMprima, $aparienciaMPrima, $olorMPrima, $colorMPrima, $pHmPrima, $densidadMPrima, $codIva, $codMPrima );
$MPrimaOperador = new MPrimasOperaciones();

try {
	$MPrimaOperador->updateMPrima($datos);
	$ruta = "listarMP.php";
	$mensaje =  "Materia prima actualzada correctamente";
	
} catch (Exception $e) {
	$ruta = "buscarMP.php";
	$mensaje = "Error al actualizar la materia prima";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje);
}


?>
