<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
?>
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
	$ruta = "listarPersonal.php";
	$mensaje =  "Personal Actualizado correctamente";
	
} catch (Exception $e) {
	$ruta = "buscarPersonal.php";
	$mensaje = "Error al actualizar al Personal";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje);
}


?>
