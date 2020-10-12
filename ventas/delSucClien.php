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

$clienteSucursalOperador = new ClientesSucursalOperaciones();
$datos = array($idCliente, $idSucursal);

try {
    $clienteSucursalOperador->deleteClienteSucursal($datos);
    $_SESSION['idCliente'] = $idCliente;
    $ruta = "detCliente.php";
    $mensaje = "Sucursal eliminada correctamente";

} catch (Exception $e) {
    $_SESSION['idCliente'] = $idCliente;
    $ruta = "detCliente.php";
    $mensaje = "Error al eliminar la sucursal";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}
