<?php
include "../includes/valAcc.php";
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

$datos = array($idCatProv, $desCatProv);
$catsProvOperador = new CategoriasProvOperaciones();
try {
    $lastCatClien = $catsProvOperador->makeCatProv($datos);
    $ruta = "listarCatProv.php";
    $mensaje = "Categoría de proveedor creada correctamente";

} catch (Exception $e) {
    $ruta = "crearCatProv.php";
    $mensaje = "Error al crear la categoría de proveedor";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}



?>
