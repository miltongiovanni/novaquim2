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

$datos = array($nomPersonal, $activoPersonal, $areaPersonal, $celPersonal, $emlPersonal, $cargoPersonal);
$personalOperador = new PersonalOperaciones();

try {
	$lastIdPersonal=$personalOperador->makePersonal($datos);
	$ruta = "listarPersonal.php";
	$mensaje =  "Personal Creado correctamente";
	
} catch (Exception $e) {
	$ruta = "makePersonalForm.php";
	$mensaje = "Error al crear el personal";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje);
}




?>
