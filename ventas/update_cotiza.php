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
        //echo $nombre_campo . print_r($valor) . '<br>';
    } else {
        //echo $nombre_campo . '=' . ${$nombre_campo} . '<br>';
    }
}
$opcionesDis = '';
if (!isset($seleccionProd)) {
    $_SESSION['idCotizacion'] = $idCotizacion;
    $ruta = "UpdateCotform.php";
    $mensaje = "Debe escoger alguna familia de los productos Novaquim";
    mover_pag($ruta, $mensaje, $icon);
} else {
    $cotizacionOperador = new CotizacionesOperaciones();
    $opcionesProd = implode(",", $seleccionProd);
    if (isset($seleccionDis)) {
        $opcionesDis = implode(",", $seleccionDis);
    }
    $datos = array($idCliente, $fechaCotizacion, $precio, $presentaciones, $opcionesDis, $opcionesProd, $destino, $idCotizacion);

    try {
        $cotizacionOperador->updateCotizacion($datos);
        $_SESSION['idCotizacion'] = $idCotizacion;
        $ruta = "det_cotiza.php";
        $mensaje = "Cotización actualizada con éxito";
    } catch (Exception $e) {
        $ruta = "cotizacion.php";
        $mensaje = "Error al actualizar la Cotización";
    } finally {
        unset($conexion);
        unset($stmt);
        mover_pag($ruta, $mensaje, $icon);
    }
}
