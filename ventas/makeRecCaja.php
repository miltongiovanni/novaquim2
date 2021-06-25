<?php
include "../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}
spl_autoload_register('cargarClases');

$idFactura = $_POST['idFactura'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Crear Recibo de caja</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<?php
$idUsuario = $_SESSION['IdUsuario'];
$recCajaOperador = new RecCajaOperaciones();
try {
    $idRecCaja = $recCajaOperador->makeRecCaja($idFactura, $idUsuario);
    $_SESSION['idRecCaja'] = $idRecCaja;
    $ruta = "recibo_caja.php";
    $mensaje = "Recibo de caja creado correctamente";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "factXcobrar.php";
    $mensaje = "Error al crear el recibo de caja";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>
