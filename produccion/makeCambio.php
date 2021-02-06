<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

//ESTOS SON LOS DATOS QUE RECIBE DE LA ORDEN DE PRODUCCIÓN

foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if(is_array($valor)){
        //echo $nombre_campo.print_r($valor).'<br>';
    }else{
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}

$datos = array($codPersonal, $fechaCambio);
$cambioOperador = new CambiosOperaciones();
try {
    $idCambio = $cambioOperador->makeCambio($datos);
    $_SESSION['idCambio'] = $idCambio;
    $ruta = "det_cambio_pres.php";
    $mensaje = "Cambio de presentación creado correctamente";

} catch (Exception $e) {

    $ruta = "../menu.php";
    $mensaje = "Error al crear el cambio de presentación";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}

