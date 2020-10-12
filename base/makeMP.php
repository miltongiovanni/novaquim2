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

$datos = array($codMPrima, $nomMPrima, $aliasMPrima, $idCatMPrima, $minStockMprima, $aparienciaMPrima, $olorMPrima, $colorMPrima, $pHmPrima, $densidadMPrima, $codIva );
$MPrimaOperador = new MPrimasOperaciones();

try {
	$lastCodProducto=$MPrimaOperador->makeMPrima($datos);
	$ruta = "listarMP.php";
	$mensaje =  "Materia prima creada correctamente";
	
} catch (Exception $e) {
	$ruta = "crearMP.php";
	$mensaje = "Error al crear la materia prima";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje);
}


?>




