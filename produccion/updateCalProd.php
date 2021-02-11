<?php
include "../includes/valAcc.php";
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
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Detalle Orden de Producción</title>
	<meta charset="utf-8">
	<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
	<script src="../js/validar.js"></script>
</head>
<body>
<?php
$datos = array( $densidadProd, $pHProd, $olorProd, $colorProd, $aparienciaProd, $observacionesProd, $lote);
$calProdOperador = new CalProdOperaciones();
try {
	$calProdOperador->updateCalProd($datos);
	$_SESSION['lote'] = $lote;
	$ruta = "det_cal_produccion.php";
	$mensaje = "Control de calidad modificado correctamente";
	$icon = "success";
} catch (Exception $e) {
	$ruta = "buscar_lote1.php";
	$mensaje = "Error al modificar el control de calidad";
	$icon = "error";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>



