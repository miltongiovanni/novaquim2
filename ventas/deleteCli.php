<?php
include "../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

$idCliente = $_POST['idCliente'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Desactivar Cliente</title>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/findCliente.js"></script>
</head>


<body>
<?php
$clienteOperador = new ClientesOperaciones();

try {
    $clienteOperador->disableCliente($idCliente);
    $ruta = "listarClien.php?estadocliente=0";
    $mensaje = "Cliente desactivado correctamente";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "buscarClien.php";
    $mensaje = "Error al desactivar el cliente";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>
