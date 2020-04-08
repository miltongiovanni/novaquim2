<?php
include "../includes/valAcc.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idDistribucion = $_POST['idDistribucion'];
$ProductoDistribucionOperador = new ProductosDistribucionOperaciones();

try {
    $ProductoDistribucionOperador->deleteProductoDistribucion($idDistribucion);
    $ruta = "listarDis.php";
    $mensaje = "Producto de Distribución eliminado correctamente";

} catch (Exception $e) {
    $ruta = "../menu.php";
    $mensaje = "No fue permitido eliminar el Producto de Distribución";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}

function mover_pag($ruta, $nota)
{
    echo '<script >
	alert("' . $nota . '")
	self.location="' . $ruta . '"
	</script>';
}

?>
