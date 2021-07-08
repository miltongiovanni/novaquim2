<?php
include "../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Seleccionar Recibo de Caja a consultar</title>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<?php
$idRecCaja = $_POST['idRecCaja'];
$recCajaOperador = new RecCajaOperaciones();
if (!$recCajaOperador->isValidIdRecCaja($idRecCaja)) {
    $ruta = "buscarRC.php";
    $mensaje = "El número de recibo de caja no es válido, vuelva a intentar de nuevo";
    $icon = "error";
    mover_pag($ruta, $mensaje, $icon);
    exit;
} else {
    $_SESSION['idRecCaja'] = $idRecCaja;
    $ruta = "recibo_caja.php";
    $mensaje = "El número de recibo de caja es válido";
    $icon = "success";
    mover_pag($ruta, $mensaje, $icon);
    exit;
}
?>
</body>
</html>
