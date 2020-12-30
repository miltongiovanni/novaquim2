<?php
include "../includes/valAcc.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
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
$facturaOperador = new FacturasOperaciones();
$facturaOr = $facturaOperador->getFactura($facturaOrigen);


$notaCreditoOperador = new NotasCreditoOperaciones();
$datos = array($fechaNotaC, $facturaOrigen, $facturaDestino, $motivo, $facturaOr['descuento'], $idNotaC);
try {
    $notaCreditoOperador->updateNotaC($datos);
    $_SESSION['idNotaC'] = $idNotaC;
    $ruta = "detalleNotaC.php";
    $mensaje = "Nota crédito actualizada con éxito";
} catch (Exception $e) {
    $ruta = "buscarNotaC.php";
    $mensaje = "Error al actualizar la nota crédito";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}


