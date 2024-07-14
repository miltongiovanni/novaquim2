<?php
include "../../../includes/valAcc.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Ingreso de Productos en la Cotización</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<?php
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
    $ruta = "../detalle/";
    $mensaje = "Detalle de la cotización personalizada adicionado con éxito";
    $icon = "success";
} catch (Exception $e) {
    $_SESSION['idCotPersonalizada'] = $idCotPersonalizada;
    $ruta = "../detalle/";
    $mensaje = "Error al ingresar el detalle de la cotización personalizada";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>