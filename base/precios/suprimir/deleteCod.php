<?php
include "../../../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
	require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$codigoGen = $_POST['codigoGen'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Eliminación de Código Genérico</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script  src="../../../js/validar.js"></script>
</head>

<body>
<?php
$PrecioOperador = new PreciosOperaciones();

try {
	$PrecioOperador->deletePrecio($codigoGen);
	$ruta = "/base/precios/lista";
	$mensaje =  "Código genérico eliminado correctamente";
	$icon = "success";
} catch (Exception $e) {
	$ruta = "/base/precios/suprimir";
	$mensaje = "Error al eliminar el código genérico";
    $icon = "error";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>
