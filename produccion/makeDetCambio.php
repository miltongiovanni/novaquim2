<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

//ESTOS SON LOS DATOS QUE RECIBE DE LA ORDEN DE PRODUCCIÓN

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
    <title>Cambio de presentación de Producto</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<?php
$CambioOperador = new CambiosOperaciones();
$DetCambioOperador = new DetCambiosOperaciones();
$PresentacionOperador = new PresentacionesOperaciones();
$presentacion = $PresentacionOperador->getPresentacion($codPresentacionAnt);
try {
    //SE ACTUALIZA EL INVENTARIO
    $InvProdTerminadoOperador = new InvProdTerminadosOperaciones();
    $invProd = $InvProdTerminadoOperador->getInvByLoteAndProd($codPresentacionAnt, $loteProd);
    $invProdNvo = $invProd - $cantPresentacionAnt;
    $datos = array($invProdNvo, $codPresentacionAnt, $loteProd);
    $InvProdTerminadoOperador->updateInvProdTerminado($datos);
    //SE GUARDA EL DETALLE DEL CAMBIO
    $datos = array($idCambio, $codPresentacionAnt, $cantPresentacionAnt, $loteProd);
    $DetCambioOperador->makeDetCambio($datos);
    //Envase
    $InvEnvaseOperador = new InvEnvasesOperaciones();
    $codEnvase = $presentacion['codEnvase'];
    $invEnvase = $InvEnvaseOperador->getInvEnvase($codEnvase);
    $nvoInvEnvase = $invEnvase + $cantPresentacionAnt;
    $datos = array($nvoInvEnvase, $codEnvase);
    $InvEnvaseOperador->updateInvEnvase($datos);
    //Tapa
    $InvTapaOperador = new InvTapasOperaciones();
    $codTapa = $presentacion['codTapa'];
    $invTapa = $InvTapaOperador->getInvTapas($codTapa);
    $nvoInvTapa = $invTapa + $cantPresentacionAnt;
    $datos = array($nvoInvTapa, $codTapa);
    $InvEnvaseOperador->updateInvEnvase($datos);
    //Etiqueta
    $InvEtiquetaOperador = new InvEtiquetasOperaciones();
    $codEtiq = $presentacion['codEtiq'];
    $invEtiq = $InvEtiquetaOperador->getInvEtiqueta($codEtiq);
    $nvoInvEtiq = $invEtiq + $cantPresentacionAnt;
    $datos = array($nvoInvEtiq, $codEtiq);
    $InvEtiquetaOperador->updateInvEtiqueta($datos);
    $_SESSION['idCambio'] = $idCambio;
    $_SESSION['presOrigen'] = true;
    $ruta = "det_cambio_pres.php";
    $mensaje = "Presentación de origen seleccionada correctamente";
    $icon = "success";
} catch (Exception $e) {
    //echo $e->getMessage();
    //Rollback the transaction.
    $_SESSION['idCambio'] = $idCambio;
    $ruta = "det_cambio_pres.php";
    $mensaje = "Error al seleccionar la presentación de origen";
    $icon = "error";
} finally {
    mover_pag($ruta, $mensaje, $icon);
}

?>
</body>
</html>
