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

$datos = array($lote, $etiquetado, $envasado, $observaciones);
$calProdTerminadoOperador = new CalProdTerminadoOperaciones();

try {
    $calProdTerminadoOperador->makeCalProdTerminado($datos);
    $envasadoOperador = new EnvasadoOperaciones();
    $presentaciones = $envasadoOperador->getPresentacionesEnvasadas($lote);
    $invProdTerminadoOperador = new InvProdTerminadosOperaciones();
    for($i=0; $i<count($presentaciones); $i++){
        $datos= array($presentaciones[$i]['codPresentacion'], $presentaciones[$i]['lote'], $presentaciones[$i]['cantPresentacion']);
        $invProdTerminadoOperador->makeInvProdTerminado($datos);
    }
    $OProdOperador = new OProdOperaciones();
    $datos = array(6, $lote);
    $OProdOperador->updateEstadoOProd($datos);
    unset($_SESSION['lote']);
    $ruta = "../menu.php";
    $mensaje = "Control de Calidad producto terminado cargado correctamente";

} catch (Exception $e) {
    $ruta = "buscar_lote2.php";
    $mensaje = "Error al ingresar el control de calidad producto terminado";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}

?>




