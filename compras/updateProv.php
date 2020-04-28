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
    //echo $nombre_campo . " = " . $valor . "<br>";
    eval($asignacion);
}

$datos = array($nitProv, $nomProv, $dirProv, $contProv, $telProv, $emailProv, $idCatProv, $autoretProv, $regProv, $idTasaIcaProv, $estProv, $idRetefuente, $idProv);
$ProveedorOperador = new ProveedoresOperaciones();

try {
    $ProveedorOperador->updateProveedor($datos);
    $ruta = "listarProv.php";
    $mensaje = "Proveedor actualizado correctamente";

} catch (Exception $e) {
    $ruta = "buscarProv.php";
    $mensaje = "Error al actualizar el proveedor";
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
