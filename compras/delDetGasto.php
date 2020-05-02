<?php
include "../includes/valAcc.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

foreach ($_POST as $nombre_campo => $valor) {
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
    //echo $nombre_campo . " = " . $valor . "<br>";
    eval($asignacion);
}

$GastoOperador = new GastosOperaciones();
$DetGastoOperador = new DetGastosOperaciones();

try {
    $datos = array($idGasto, $producto);
    $DetGastoOperador->deleteDetGasto( $datos);
    $GastoOperador->updateTotalesGasto(BASE_C, $idGasto);
    $_SESSION['idGasto'] = $idGasto;
    $ruta = "detGasto.php";
    $mensaje = "Detalle de gasto eliminado con éxito";
} catch (Exception $e) {
    $_SESSION['idGasto'] = $idGasto;
    $ruta = "detGasto.php";
    $mensaje = "Error al eliminar el detalle del gasto";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}

function mover_pag($ruta, $Mensaje)
{
    echo '<script >
   alert("' . $Mensaje . '")
   self.location="' . $ruta . '"
   </script>';
}

?>
