<?php
include "../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idRemision = $_POST['idRemision'];
$remisionOperador = new RemisionesOperaciones();
if (!$remisionOperador->isValidRemision($idRemision)) {
    $ruta = "seleccionarRemision.php";
    $mensaje = "El número de la remisión no es válido, vuelva a intentar de nuevo";
    $icon = "warning";
    mover_pag($ruta, $mensaje, $icon);
    exit;
} else {
    $_SESSION['idRemision'] = $idRemision;
    $ruta = "det_remision.php";
    $mensaje = "El número de la remisión es válido";
    $icon = "success";
    mover_pag($ruta, $mensaje, $icon);
    exit;
}
