<?php
include "../../../includes/valAcc.php";
include "../../../includes/calcularDias.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if (is_array($valor)) {
        //echo $nombre_campo . print_r($valor) . '<br>';
    } else {
        //echo $nombre_campo . '=' . ${$nombre_campo} . '<br>';
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Crear Nota Crédito</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<?php
$notaCreditoOperador = new NotasCreditoOperaciones();
$facturaOperador = new FacturasOperaciones();
$notaC = $notaCreditoOperador->getNotaC($idNotaC);
$facturaDest = $facturaOperador->getFactura($idFacturaDestino);
try {
    if ($facturaDest['total'] >= $notaC['totalNotaC']) {
        $notaCreditoOperador->updateFacturaDestNotaC($idFacturaDestino, $idNotaC);
    }
    $_SESSION['idNotaC'] = $idNotaC;
    $ruta = "detalleNotaC.php";
    $mensaje = "Nota crédito actualizada con éxito";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "crearNotaC.php";
    $mensaje = "Error al actualizar la nota crédito";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>