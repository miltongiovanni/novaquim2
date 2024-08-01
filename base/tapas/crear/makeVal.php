<?php
include "../../../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
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
        <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
        <title>Creación de Tapas y Válvulas</title>
        <meta charset="utf-8">
        <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
        <script src="../../../js/validar.js"></script>
    </head>
<body>

<?php
$TapaOperador = new TapasOperaciones();
$datos = array($codTapa, $tapa,  $stockTapa, $codIva );

try {
	$lastCodTapa=$TapaOperador->makeTapa($datos);
	$ruta = "/base/tapas/lista";
	$mensaje =  "Tapa creada correctamente";
	$icon = "success";
} catch (Exception $e) {
	$ruta = "/base/tapas/crear";
	$mensaje = "Error al crear la tapa";
    $icon = "error";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje, $icon);
}
	

?>

</body>
</html>
