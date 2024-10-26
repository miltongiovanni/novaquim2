<?php include "../../../includes/valAcc.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Crear Cotización</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<?php
$opcionesDis = '';
if (!isset($seleccionProd)) {
    $ruta = "../crear/";
    $mensaje = "Debe escoger alguna familia de los productos Novaquim";
    $icon = "warning";
    mover_pag($ruta, $mensaje, $icon);
    exit;
} else {
    $cotizacionOperador = new CotizacionesOperaciones();
    $opcionesProd = implode(",", $seleccionProd);
    if (isset($seleccionDis)) {
        $opcionesDis = implode(",", $seleccionDis);
    }
    $datos = array($idCliente, $fechaCotizacion, $precio, $presentaciones, $opcionesDis, $opcionesProd, $destino);

    try {
        $lastIdCotizacion = $cotizacionOperador->makeCotizacion($datos);
        $_SESSION['idCotizacion'] = $lastIdCotizacion;
        $ruta = "../detalle/";
        $mensaje = "Cotización creada con éxito";
        $icon = "success";
    } catch (Exception $e) {
        $ruta = "../crear/";
        $mensaje = "Error al crear la Cotización";
        $icon = "error";
    } finally {
        unset($conexion);
        unset($stmt);
        mover_pag($ruta, $mensaje, $icon);
    }
}
?>
