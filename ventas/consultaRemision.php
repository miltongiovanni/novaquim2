<?php
include "../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$idRemision = $_POST['idRemision'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Seleccionar Factura a Modificar</title>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<?php
$remisionOperador = new RemisionesOperaciones();
if (!$remisionOperador->isValidRemision($idRemision)) {
    $ruta = "seleccionarRemision.php";
    $mensaje = "El número de la remisión no es válido, vuelva a intentar de nuevo";
    $icon = "warning";
    mover_pag($ruta, $mensaje, $icon);
    exit;
} else {
    $_SESSION['idRemision'] = $idRemision;
    $ruta = "det_remision.php";
    $mensaje = "El número de la remisión es válido";
    $icon = "success";
    mover_pag($ruta, $mensaje, $icon);
    exit;
}
?>
</body>
</html>
