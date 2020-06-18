<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

//ESTOS SON LOS DATOS QUE RECIBE DE LA ORDEN DE PRODUCCIÓN

foreach ($_POST as $nombre_campo => $valor) {
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
    //echo $nombre_campo . " = " . $valor . "<br>";
    eval($asignacion);
}
$CambioOperador = new CambiosOperaciones();
$DetCambioOperador = new DetCambiosOperaciones();
$PresentacionOperador = new PresentacionesOperaciones();
$presentacion = $PresentacionOperador->getPresentacion($codPresentacionNvo);
try {
    //SE ACTUALIZA EL INVENTARIO
    $InvProdTerminadoOperador = new InvProdTerminadosOperaciones();
    $invProd = $InvProdTerminadoOperador->getInvByLoteAndProd($codPresentacionNvo, $loteProd);
    if($invProd>0){
        $invProdNvo = $invProd + $cantPresentacionNvo;
        $datos = array($invProdNvo, $codPresentacionNvo, $loteProd);
        $InvProdTerminadoOperador->updateInvProdTerminado($datos);
    }
    else{
        $datos = array($codPresentacionNvo, $loteProd, $invProdNvo);
        $InvProdTerminadoOperador->makeInvProdTerminado($datos);
    }




    //SE GUARDA EL DETALLE DEL CAMBIO
    $datos = array($idCambio, $codPresentacionNvo, $cantPresentacionNvo, $loteProd);
    $DetCambioOperador->makeDetCambio2($datos);
    //Envase
    $InvEnvaseOperador = new InvEnvasesOperaciones();
    $codEnvase = $presentacion['codEnvase'];
    $invEnvase = $InvEnvaseOperador->getInvEnvase($codEnvase);
    $nvoInvEnvase = $invEnvase - $cantPresentacionNvo;
    $datos= array($nvoInvEnvase, $codEnvase);
    $InvEnvaseOperador->updateInvEnvase($datos);
    //Tapa
    $InvTapaOperador = new InvTapasOperaciones();
    $codTapa = $presentacion['codTapa'];
    $invTapa = $InvTapaOperador->getInvTapas($codTapa);
    $nvoInvTapa = $invTapa - $cantPresentacionNvo;
    $datos=array($nvoInvTapa,$codTapa );
    $InvEnvaseOperador->updateInvEnvase($datos);
    //Etiqueta
    $InvEtiquetaOperador = new InvEtiquetasOperaciones();
    $codEtiq = $presentacion['codEtiq'];
    $invEtiq = $InvEtiquetaOperador->getInvEtiqueta($codEtiq);
    $nvoInvEtiq = $invEtiq - $cantPresentacionNvo;
    $datos=array($nvoInvEtiq,$codEtiq );
    $InvEtiquetaOperador->updateInvEtiqueta($datos);
    $_SESSION['idCambio'] = $idCambio;
    $_SESSION['presDestino'] = true;
    $ruta = "det_cambio_pres.php";
    $mensaje = "Presentación de destino cambiada correctamente";

} catch (Exception $e) {
    //echo $e->getMessage();
    //Rollback the transaction.
    $_SESSION['idCambio'] = $idCambio;
    $ruta = "det_cambio_pres.php";
    $mensaje = "Error al cambiar la presentación";
} finally {
    mover_pag($ruta, $mensaje);
}


