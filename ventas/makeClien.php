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

$estadoCliente = 1;
$fchCreacionCliente = date("Y-m-d");
$datos = array($nitCliente, $nomCliente, $contactoCliente, $cargoCliente, $telCliente, $celCliente, $dirCliente, $emailCliente, $estadoCliente, $idCatCliente, $ciudadCliente, $retIva, $retIca, $retFte, $codVendedor, $fchCreacionCliente, 0);
$clienteOperador = new ClientesOperaciones();
try {
    $nitExist = $clienteOperador->checkNit($nitCliente);
    if (isset($nitExist['idCliente']) && $nitExist['idCliente'] != null) {
        $_SESSION['idCliente'] = $nitExist['idCliente'];
        header('Location: detCliente.php');
    } else {
        $lastIdCliente = $clienteOperador->makeCliente($datos);
        $datosSucursal = array($lastIdCliente, 1, $dirCliente, $ciudadCliente, $telCliente, $nomCliente);
        $clienteSucursalOperador = new ClientesSucursalOperaciones();
        $clienteSucursalOperador->makeClienteSucursal($datosSucursal);
        $_SESSION['idCliente'] = $lastIdCliente;
        $ruta = "detCliente.php";
        $mensaje = "Cliente creado con éxito";
    }
} catch (Exception $e) {
    $ruta = "makeClienForm.php";
    $mensaje = "Error al crear el Cliente";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}



