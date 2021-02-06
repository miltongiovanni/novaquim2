<?php include "../includes/valAcc.php";
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
if ($cliExis == 1) {
    $clienteOperador = new ClientesOperaciones();
    $cliente = $clienteOperador->getCliente($idCliente);
    $datos = array($cliente['nomCliente'], $cliente['contactoCliente'], $cliente['cargoCliente'], $cliente['telCliente'], $cliente['celCliente'], $cliente['dirCliente'], $cliente['emailCliente'], $cliente['idCatCliente'], $cliente['ciudadCliente'], $cliente['codVendedor']);
} else {
    $datos = array($nomCliente, $contactoCliente, $cargoContacto, $telCliente, $celCliente, $dirCliente, $emailCliente, $idCatCliente, $idCiudad, $codVendedor);
}
try {
    $lastIdCliente = $clienteCotizacionOperador->makeCliente($datos);
    $ruta = "listarClientCot.php";
    $mensaje = "Cliente creado con éxito";
} catch (Exception $e) {
    $ruta = "makeClienCotForm.php";
    $mensaje = "Error al crear el Cliente";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}

