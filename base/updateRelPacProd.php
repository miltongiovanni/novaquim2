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
    //echo $nombre_campo." = ".$valor."<br>";
    eval($asignacion);
}

$datos = array($codPaca, $codUnidad, $cantidad, $idPacUn);
$relDisEmpOperador = new RelDisEmpOperaciones();

try {
    $relDisEmpOperador->updateRelDisEmp($datos);
    $ruta = "listarDes.php";
    $mensaje = "Relación paca unidad producto de distribución actualizada correctamente";

} catch (Exception $e) {
    $ruta = "buscarRelPacProd.php";
    $mensaje = "Error al actualizar la relación paca unidad producto de distribución";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}



?>
