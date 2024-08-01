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
	<title>Creación de Categoría de Materias Primas</title>
	<meta charset="utf-8">
	<script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
	<script  src="../../../js/validar.js"></script>

</head>

<body>

<?php
$datos = array($idCatMP, $catMP);
$catsMPOperador = new CategoriasMPOperaciones();

try {
	$lastCatMP=$catsMPOperador->makeCatMP($datos);
	$ruta = "/base/categorias-mprima/lista";
	$mensaje =  "Categoría de materia prima creada correctamente";
	$icon="success";
} catch (Exception $e) {
	$ruta = "/base/categorias-mprima/crear";
	$mensaje = "Error al crear la categoría de materia prima";
	$icon="error";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>
