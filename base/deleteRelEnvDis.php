<?php
include "../includes/valAcc.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idEnvDis = $_POST['idEnvDis'];
$relEnvDisOperador = new RelEnvDisOperaciones();

try {
    $relEnvDisOperador->deleteRelEnvDis($idEnvDis);
    $ruta = "listarenvaseDis.php";
    $mensaje = "Relación Envase Producto de Distribución eliminada correctamente";

} catch (Exception $e) {
    $ruta = "buscarRelEnvDis.php";
    $mensaje = "No fue permitido eliminar la relación Envase Producto de Distribución";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}

function mover_pag($ruta, $nota)
{
    echo '<script language="Javascript">
	alert("' . $nota . '")
	self.location="' . $ruta . '"
	</script>';
}

?>
