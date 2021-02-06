<?php
include "../includes/valAcc.php";

function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$invDistribucionOperador = new InvDistribucionOperaciones();
$relEnvDisOperador = new RelEnvDisOperaciones();
$invEnvaseOperador = new InvEnvasesOperaciones();
$invTapaOperador = new InvTapasOperaciones();
$idDis = $_POST['idDis'];
$unidades = $_POST['unidades'];

$relacionEnvDis = $relEnvDisOperador->getRelEnvDisByidDis($idDis);
$invEnvase = $invEnvaseOperador->getInvEnvase($relacionEnvDis['codEnvase']);
$invTapa = $invTapaOperador->getInvTapas($relacionEnvDis['codTapa']);

try {
    if (($invTapa >= $unidades) && ($invEnvase >= $unidades)) {
        $invDistribucion = $invDistribucionOperador->getInvDistribucion($relacionEnvDis['idDis']);
        $nvoInvDistribucion = $invDistribucion + $unidades;
        $datos = array($nvoInvDistribucion, $relacionEnvDis['idDis']);
        $invDistribucionOperador->updateInvDistribucion($datos);

        $nvoInvEnvase = $invEnvase - $unidades;
        $datos = array($nvoInvEnvase, $relacionEnvDis['codEnvase']);
        $invEnvaseOperador->updateInvEnvase($datos);

        $nvoInvTapas = $invTapa - $unidades;
        $datos = array($nvoInvTapas, $relacionEnvDis['codTapa']);
        $invTapaOperador->updateInvTapas($datos);

        $ruta = "../menu.php";
        $mensaje = "Carga de envase como producto de distribución realizado con éxito";
    } else {
        $ruta = "cargarEnvase.php";
        $mensaje = "No hay inventario suficiente de Envases o Tapa";
    }

} catch (Exception $e) {
    $ruta = "cargarEnvase.php";
    $mensaje = "Error al cargar el envase como producto de distribución";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}


