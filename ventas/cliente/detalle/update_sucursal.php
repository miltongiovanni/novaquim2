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
    <title>Modificar Sucursal </title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<?php
$clienteSucursalOperador = new ClientesSucursalOperaciones();
$datos = array($dirSucursal, $ciudadSucursal, $telSucursal, $nomSucursal, $idCliente, $idSucursal);

try {
    $clienteSucursalOperador->updateClienteSucursal($datos);
    $_SESSION['idCliente'] = $idCliente;
    $ruta = "detCliente.php";
    $mensaje = "Sucursal actualizada correctamente";
    $icon = "success";
} catch (Exception $e) {
    $_SESSION['idCliente'] = $idCliente;
    $ruta = "detCliente.php";
    $mensaje = "Error al actualizar la sucursal";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>
