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

$clienteCotizacionOperador = new ClientesCotizacionOperaciones();
$datos = array($nomCliente, $contactoCliente, $cargoContacto, $telCliente, $celCliente, $dirCliente, $emailCliente, $idCatCliente, $idCiudad, $codVendedor, $idCliente);
try {
    $clienteCotizacionOperador->updateCliente($datos);
    $ruta = "listarClientCot.php";
    $mensaje = "Cliente de cotización actualizado con éxito";
} catch (Exception $e) {
    $ruta = "buscarClientCot.php";
    $mensaje = "Error al actualizar el Cliente de cotización";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}



