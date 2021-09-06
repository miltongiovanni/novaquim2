<?php
include "../includes/valAcc.php";
foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if(is_array($valor)){
        //echo $nombre_campo.print_r($valor).'<br>';
    }else{
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar datos de detalle orden de producción</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<?php
$EnvasadoOperador = new EnvasadoOperaciones();
$presentacion = $EnvasadoOperador->getEnvasado($lote, $codPresentacion);
$_SESSION['lote'] = $lote;
$OProdOperador = new OProdOperaciones();
$ordenProd = $OProdOperador->getOProd($lote);

try {
    $cambio = $cantPresentacion - $cantidad_ant;
    $volumenEnvasado = $EnvasadoOperador->getVolumenEnvasado($codPresentacion, $cambio);
    if (($cantidadPendiente - $volumenEnvasado) < -($ordenProd['cantidadKg'] *  2 * 0.15 / ($ordenProd['densMin'] + $ordenProd['densMax']))) {
        $ruta = "det_Envasado.php";
        $mensaje = "No se puede envasar la presentación del producto, se necesita " . round($volumenEnvasado, 2) . " litros y sólo hay " . round($cantidadPendiente, 2) . " litros";
        $icon = "warning";
        mover_pag($ruta, $mensaje, $icon);
    } else {
        //SE ACTUALIZA EL INVENTARIO
        $InvProdTerminadoOperador = new InvProdTerminadosOperaciones();
        $invProd = $InvProdTerminadoOperador->getInvProdTerminadoByLote($codPresentacion, $lote);
        $nvoInvProd = $invProd + $cambio;
        $datos = array($nvoInvProd, $codPresentacion, $lote);
        $InvProdTerminadoOperador->updateInvProdTerminado($datos);
        //SE ACTUALIZA EL ENVASE
        $InvEnvaseOperador = new InvEnvasesOperaciones();
        $codEnvase = $presentacion['codEnvase'];
        $invEnvase = $InvEnvaseOperador->getInvEnvase($codEnvase);
        $nvoInvEnvase = $invEnvase - $cambio;
        $datos = array($nvoInvEnvase, $codEnvase);
        $InvEnvaseOperador->updateInvEnvase($datos);
        //SE ACTUALIZA LA TAPA
        $InvTapaOperador = new InvTapasOperaciones();
        $codTapa = $presentacion['codTapa'];
        $invTapa = $InvTapaOperador->getInvTapas($codTapa);
        $nvoInvTapa = $invTapa - $cambio;
        $datos = array($nvoInvTapa, $codTapa);
        $InvTapaOperador->updateInvTapas($datos);
        //SE ACTUALIZA LA ETIQUETA
        $InvEtiquetaOperador = new InvEtiquetasOperaciones();
        $codEtiq = $presentacion['codEtiq'];
        $invEtiq = $InvEtiquetaOperador->getInvEtiqueta($codEtiq);
        $nvoInvEtiq = $invEtiq - $cambio;
        $datos = array($nvoInvEtiq, $codEtiq);
        $InvEtiquetaOperador->updateInvEtiqueta($datos);
        $datos=array($cantPresentacion, $lote, $codPresentacion);
        $EnvasadoOperador->updateEnvasado($datos);
        $mensaje = "Envasado actualizado correctamente";
        $_SESSION['lote'] = $lote;
        $ruta = "det_Envasado.php";
        $icon = "success";
    }
}catch (Exception $e) {
    $_SESSION['lote'] = $lote;
    $ruta = "det_Envasado.php";
    $mensaje = "Error al actualizar el envasado del producto";
    $icon = "error";
} finally {
    mover_pag($ruta, $mensaje, $icon);
}

?>
</body>
</html>
