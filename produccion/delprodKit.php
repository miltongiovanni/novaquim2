<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
//ESTOS SON LOS DATOS QUE RECIBE PARA CREAR EL KIT
foreach ($_POST as $nombre_campo => $valor) {
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
    //echo $nombre_campo . " = " . $valor . "<br>";
    eval($asignacion);
}
$DetKitOperador = new DetKitsOperaciones();
try {
    $DetKitOperador->deleteDetKit($idKit, $codProducto);
    $_SESSION['idKit'] = $idKit;
    $ruta = "det_kits.php";
    $mensaje = "Detalle de Kit eliminado correctamente";

} catch (Exception $e) {

    $ruta = "../menu.php";
    $mensaje = "Error al eliminar el detalle de kit";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}

