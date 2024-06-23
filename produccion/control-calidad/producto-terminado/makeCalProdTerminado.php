<?php
include "../../../includes/valAcc.php";
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
$datos = array($lote, $etiquetado, $envasado, $observaciones);
$calProdTerminadoOperador = new CalProdTerminadoOperaciones();

try {
    $calProdTerminadoOperador->makeCalProdTerminado($datos);
    $envasadoOperador = new EnvasadoOperaciones();
    $presentaciones = $envasadoOperador->getPresentacionesEnvasadas($lote);
    /*$invProdTerminadoOperador = new InvProdTerminadosOperaciones();
    for ($i = 0; $i < count($presentaciones); $i++) {
        $datos = array($presentaciones[$i]['codPresentacion'], $presentaciones[$i]['lote'], $presentaciones[$i]['cantPresentacion']);
        $invProdTerminadoOperador->makeInvProdTerminado($datos);
    }*/
    $OProdOperador = new OProdOperaciones();
    $datos = array(6, $lote);
    $OProdOperador->updateEstadoOProd($datos);
    unset($_SESSION['lote']);
    $ruta = "../../../menu.php";
    $mensaje = "Control de Calidad producto terminado cargado correctamente";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "../producto-terminado/";
    $mensaje = "Error al ingresar el control de calidad producto terminado";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}

?>
</body>
</html>



