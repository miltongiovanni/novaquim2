<?php
include "../../../includes/valAcc.php";
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
	<title>Actualizar datos del Usuario</title>
	<script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
	<script src="../../../js/validar.js"></script>
</head>

<body>

<?php


foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if(is_array($valor)){
        //echo $nombre_campo.print_r($valor).'<br>';
    }else{
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}

$datos = array($nomPersonal, $activoPersonal, $areaPersonal, $celPersonal, $emlPersonal, $cargoPersonal, $idPersonal );
$personalOperador = new PersonalOperaciones();

try {
	$personalOperador->updatePersonal($datos);
	$ruta = "/administracion/personal/lista";
	$mensaje =  "Personal Actualizado correctamente";
	$icon = 'success';
	
} catch (Exception $e) {
	$ruta = "/administracion/personal/modificar";
	$mensaje = "Error al actualizar al Personal";
	$icon = 'error';
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje, $icon);
}


?>
</body>
</html>