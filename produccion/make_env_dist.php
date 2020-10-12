<?php
include "../includes/valAcc.php";
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
$datos = array($codMPrimaDist, $codDist, $codMedida, $codEnvase, $codTapa);
$RelDisMPrimaOperador = new RelDisMPrimaOperaciones();
try {
    $RelDisMPrimaOperador->makeRelEnvDis($datos);
    $ruta = "../menu.php";
    $mensaje = "Relación creada correctamente";

} catch (Exception $e) {
    $ruta = "rel_env_dist.php";
    $mensaje = "Error al crear la relación Distribución - Materia prima";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}


?>




