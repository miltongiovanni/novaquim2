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
    if (is_array($valor)) {
        //echo $nombre_campo.print_r($valor).'<br>';
    } else {
        //echo $nombre_campo . '=' . ${$nombre_campo} . '<br>';
    }
}
$detCotizacionOperador = new DetCotizacionPersonalizadaOperaciones();
$datos = array($canProducto, $precioProducto, $idCotPersonalizada, $codProducto);
try {
    $detCotizacionOperador->updateDetCotPersonalizada($datos);
    $_SESSION['idCotPersonalizada'] = $idCotPersonalizada;
    $ruta = "det_cot_personalizada.php";
    $mensaje = "Detalle de la cotización personalizada actualizado con éxito";

} catch (Exception $e) {
    $_SESSION['idCotPersonalizada'] = $idCotPersonalizada;
    $ruta = "det_cot_personalizada.php";
    $mensaje = "Error al actualizar el detalle de la cotización personalizada";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}

