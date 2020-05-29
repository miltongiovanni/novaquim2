<?php
include "../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');

$codProducto = $_POST['codProducto'];
$ProductoOperador = new ProductosOperaciones();

try {
    $ProductoOperador->deleteProducto($codProducto);
    $ruta = "listarProd.php";
    $mensaje = "Producto eliminado correctamente";

} catch (Exception $e) {
    $ruta = "../menu.php";
    $mensaje = "No fue permitido eliminar el Producto";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}
?>
