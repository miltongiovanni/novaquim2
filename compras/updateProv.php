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
    mover_pag($ruta, $mensaje, $icon);
}



?>
