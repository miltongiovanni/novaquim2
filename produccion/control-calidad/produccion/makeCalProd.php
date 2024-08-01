<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Control de calidad orden de producción</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<?php
$datos = array($lote, $densidadProd, $pHProd, $olorProd, $colorProd, $aparienciaProd, $observacionesProd);
$calProdOperador = new CalProdOperaciones();

try {
    $calProdOperador->makeCalProd($datos);
    $OProdOperador = new OProdOperaciones();
    $datos = array(1, $lote);
    $OProdOperador->updateEstadoOProd($datos);
    $_SESSION['lote'] = $lote;
    $ruta = "det_cal_produccion.php";
    $mensaje = "Control de Calidad cargado correctamente";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "../produccion/";
    $mensaje = "Error al ingresar el Control de Calidad";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>



