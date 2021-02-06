<?php
include "../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$idFactura = $_POST['idFactura'];

$recCajaOperador = new RecCajaOperaciones();


try {
    $idRecCaja = $recCajaOperador->makeRecCaja($idFactura);
    $_SESSION['idRecCaja'] = $idRecCaja;
    $ruta = "recibo_caja.php";
    $mensaje = "Recibo de caja creado correctamente";

} catch (Exception $e) {
    $ruta = "factXcobrar.php";
    $mensaje = "Error al crear el recibo de caja";

} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}




?>
