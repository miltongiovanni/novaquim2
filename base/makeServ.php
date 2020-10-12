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

$datos = array($idServicio, $desServicio, $codIva, 1, $codSiigo);
$servicioperador = new ServiciosOperaciones();

try {
    $lastCodServicio=$servicioperador->makeServicio($datos);
    $ruta = "listarServ.php";
    $mensaje =  "Servicio creado correctamente";

} catch (Exception $e) {
    $ruta = "crearServ.php";
    $mensaje = "Error al crear el Servicio";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}



?>
