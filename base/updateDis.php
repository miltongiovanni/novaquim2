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

$datos = array($producto, $codIva, $precioVta, $cotiza, $activo, $stockDis, $idDistribucion);
$ProductoDistribucionOperador = new ProductosDistribucionOperaciones();

try {
    $ProductoDistribucionOperador->updateProductoDistribucion($datos);
    $ruta = "listarDis.php";
    $mensaje = "Producto de Distribución actualizado correctamente";

} catch (Exception $e) {
    $ruta = "buscarDis.php";
    $mensaje = "Error al actualizar el Producto de Distribución";
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
