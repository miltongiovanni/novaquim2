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
    if(is_array($valor)){
        //echo $nombre_campo.print_r($valor).'<br>';
    }else{
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
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



?>
