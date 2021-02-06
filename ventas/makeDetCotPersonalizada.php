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
$cotizacionOperador = new CotizacionesPersonalizadasOperaciones();
$detCotizacionOperador = new DetCotizacionPersonalizadaOperaciones();

try {
    if ($codProducto > 100000) {
        //PRODUCTOS DE DISTRIBUCIÓN
        $distribucionOperador = new ProductosDistribucionOperaciones();
        $precioProducto = $distribucionOperador->getPrecioVtaProductoDistribucion($codProducto);

    } else {
        //PRODUCTOS DE LA EMPRESA
        $presentacionOperador = new PresentacionesOperaciones();
        $precioProducto = $presentacionOperador->getPrecioPresentacion($codProducto, $tipoPrecio);
    }
    $datos = array($idCotPersonalizada, $codProducto, $cantProducto, $precioProducto);
    $detCotizacionOperador->makeDetCotPersonalizada($datos);
    $_SESSION['idCotPersonalizada'] = $idCotPersonalizada;
    $ruta = "det_cot_personalizada.php";
    $mensaje = "Detalle de la cotización personalizada adicionado con éxito";

} catch (Exception $e) {
    $_SESSION['idCotPersonalizada'] = $idCotPersonalizada;
    $ruta = "det_cot_personalizada.php";
    $mensaje = "Error al ingresar el detalle de la cotización personalizada";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}

