<?php
include "../../../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
	require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Eliminar Materias Primas</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>

<body>
<?php
$codMPrima = $_POST['codMPrima'];
$MPrimaOperador = new MPrimasOperaciones();
try {
	$MPrimaOperador->deleteMPrima($codMPrima);
	$ruta = "/base/materia-prima/lista";
	$mensaje =  "Materia prima eliminada correctamente";
	$icon = "success";
} catch (Exception $e) {
	$ruta = "/base/materia-prima/suprimir";
	$mensaje = "Error al eliminar la materia prima";
    $icon = "error";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje, $icon);
}
	

?>
</body>
</html>
