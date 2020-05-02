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
$estProv = 1;
$datos = array(0, $nitProv, $nomProv, $dirProv, $contProv, $telProv, $emailProv, $idCatProv, $autoretProv, $regProv, $idTasaIcaProv, $estProv, $idRetefuente);
$ProveedorOperador = new ProveedoresOperaciones();

try {
    $nitExist = $ProveedorOperador->checkNit($nitProv);
    if (isset($nitExist['idProv']) && $nitExist['idProv'] != null) {
        $_SESSION['idProv'] = $nitExist['idProv'];
        header('Location: updateProvForm.php');
    } else {
        $lastIdProv = $ProveedorOperador->makeProveedor($datos);
        $_SESSION['idProv'] = $lastIdProv;
        $ruta = "detProveedor.php";
        $mensaje = "Proveedor creado con éxito";
    }
} catch (Exception $e) {
    $ruta = "makeProvForm.php";
    $mensaje = "Error al crear el Proveedor";
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
