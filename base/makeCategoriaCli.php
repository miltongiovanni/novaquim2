<?php
include "../includes/valAcc.php";
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
$datos = array($idCatClien, $desCatClien);
$catsCliOperador = new CategoriasCliOperaciones();
try {
    $lastCatClien = $catsCliOperador->makeCatCli($datos);
    $ruta = "listarCatCli.php";
    $mensaje = "Categoría de cliente creada correctamente";

} catch (Exception $e) {
    $ruta = "crearCatCli.php";
    $mensaje = "Error al crear la categoría de cliente";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}



?>
