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

$datos = array($idDis, $idEnv, $idTapa, $idEnvDis);
$relEnvDisOperador = new RelEnvDisOperaciones();

try {
    $relEnvDisOperador->updateRelEnvDis($datos);
    $ruta = "listarenvaseDis.php";
    $mensaje = "Relación Envase Producto de Distribución actualizada correctamente";

} catch (Exception $e) {
    $ruta = "buscarRelEnvDis.php";
    $mensaje = "Error al actualizar la relación Envase Producto de Distribución";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}



?>
