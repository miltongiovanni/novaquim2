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

$datos = array($idDis, $idEnv, $idTapa, $idEnvDis);
$relEnvDisOperador = new RelEnvDisOperaciones();

try {
    $relEnvDisOperador->updateRelEnvDis($datos);
    $ruta = "listarenvaseDis.php";
    $mensaje = "Relación Envase Producto de Distribución actualizada correctamente";

} catch (Exception $e) {
    $ruta = "buscarRelEnvDis.php";
    $mensaje = "Error al actualizar la relación Envase Producto de Distribución";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}

function mover_pag($ruta, $Mensaje)
{
    echo '<script language="Javascript">
   	alert("' . $Mensaje . '")
   	self.location="' . $ruta . '"
   	</script>';
}

?>
