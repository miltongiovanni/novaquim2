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
    <title>Creación cotización personalizada</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<?php
$cotizacionOperador = new CotizacionesPersonalizadasOperaciones();
$datos = array($idCliente, $fechaCotizacion, $tipPrecio, $destino);

try {
    $lastIdCotizacion = $cotizacionOperador->makeCotizacionP($datos);
    $_SESSION['idCotPersonalizada'] = $lastIdCotizacion;
    $ruta = "det_cot_personalizada.php";
    $mensaje = "Cotización personalizada creada con éxito";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "cotizacion.php";
    $mensaje = "Error al crear la Cotización personalizada";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>