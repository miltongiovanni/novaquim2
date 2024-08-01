<?php
include "../../../includes/valAcc.php";


// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if (is_array($valor)) {
        //echo $nombre_campo.print_r($valor).'<br>';
    } else {
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar datos del Cliente</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>

</head>

<body>
<?php
$clienteCotizacionOperador = new ClientesCotizacionOperaciones();
$datos = array($nomCliente, $contactoCliente, $cargoContacto, $telCliente, $celCliente, $dirCliente, $emailCliente, $idCatCliente, $idCiudad, $codVendedor, $idCliente);
try {
    $clienteCotizacionOperador->updateCliente($datos);
    $ruta = "../lista/";
    $mensaje = "Cliente de cotización actualizado con éxito";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "buscarClientCot.php";
    $mensaje = "Error al actualizar el Cliente de cotización";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>


