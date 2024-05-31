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
    <title>Actualizar datos del Cliente</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<?php
$datos = array($nitCliente, $nomCliente, $contactoCliente, $cargoCliente, $telCliente, $celCliente, $dirCliente, $emailCliente, $estadoCliente, $idCatCliente, $ciudadCliente, $retIva, $retIca, $retFte, $codVendedor, $exenIva, $idCliente);
$clienteOperador = new ClientesOperaciones();

try {
    $clienteOperador->updateCliente($datos);
    $ruta = "listarClien.php?estadocliente=" . $estadoCliente;
    $mensaje = "Cliente actualizado correctamente";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "buscarClien.php";
    $mensaje = "Error al actualizar el cliente";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>
