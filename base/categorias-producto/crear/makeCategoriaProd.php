<?php
include "../../../includes/valAcc.php";
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
	<title>Creación de Categoría de Productos</title>
	<meta charset="utf-8">
	<script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
	<script src="../../../js/validar.js"></script>
</head>

<body>
<?php
$datos = array($idCatProd, $catProd);
$catsProdOperador = new CategoriasProdOperaciones();

try {
	$lastCatProd=$catsProdOperador->makeCatProd($datos);
	$ruta = "../lista/";
	$mensaje =  "Categoría de producto creada correctamente";
	$icon="success";
} catch (Exception $e) {
	$ruta = "../crear/";
	$mensaje = "Error al crear la categoría de producto";
	$icon="error";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>