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

$datos = array($nomProducto, $idCatProd, $prodActivo, $densMin, $densMax, $pHmin, $pHmax, $fragancia, $color, $apariencia, $codProducto);
$ProductoOperador = new ProductosOperaciones();

try {
    $ProductoOperador->updateProducto($datos);
    $ruta = "listarProd.php";
    $mensaje = "Producto actualizado correctamente";

} catch (Exception $e) {
    $ruta = "crearProd.php";
    $mensaje = "Error al actualizar el producto";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}



?>
