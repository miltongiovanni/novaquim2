<?php include "../../../includes/valAcc.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Creación de Clientes para Cotización</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
<body>
<?php

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
    $ruta = "../lista/";
    $mensaje = "Cliente creado con éxito";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "../crear/";
    $mensaje = "Error al crear el Cliente";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
