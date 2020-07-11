<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
	require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";
	eval($asignacion); 
}

$datos = array( $densidadProd, $pHProd, $olorProd, $colorProd, $aparienciaProd, $observacionesProd, $lote);
$calProdOperador = new CalProdOperaciones();

try {
	$calProdOperador->updateCalProd($datos);
	$_SESSION['lote'] = $lote;
	$ruta = "det_cal_produccion.php";
	$mensaje = "Control de calidad modificado correctamente";

} catch (Exception $e) {
	$ruta = "buscar_lote1.php";
	$mensaje = "Error al modificar el control de calidad";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje);
}

?>




