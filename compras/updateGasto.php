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
$datos = array($idProv, $numFact, $fechGasto, $fechVenc, $idGasto);

try {
    $GastoOperador->updateGasto($datos);
    $_SESSION['idGasto'] = $idGasto;
    $ruta = "detGasto.php";
    $mensaje = "Gasto actualizado con éxito";

} catch (Exception $e) {
    $ruta = "buscarGasto.php";
    $mensaje = "Error al actualizar el gasto";
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
