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
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<?php
$fechaActual = hoy();
$diasNotaC = Calc_Dias($fechaNotaC, $fechaActual);
$facturaOperador = new FacturasOperaciones();
$facturaOr = $facturaOperador->getFactura($facturaOrigen);
$facturaDest = $facturaOperador->getFactura($facturaDestino);
if ($facturaDest['Estado']=='C'){
    $facturaDestino=null;
}
if ($diasNotaC >= 0) {
    $notaCreditoOperador = new NotasCreditoOperaciones();
    $datos = array($idCliente, $fechaNotaC, $facturaOrigen, $facturaDestino, $motivo, $facturaOr['descuento']);
    try {
        $lastIdNotaCr = $notaCreditoOperador->makeNotaC($datos);
        $_SESSION['idNotaC'] = $lastIdNotaCr;
        $ruta = "detalleNotaC.php";
        $mensaje = "Nota crédito creada con éxito";
        $icon = "success";
    } catch (Exception $e) {
        $ruta = "crearNotaC.php";
        $mensaje = "Error al crear la nota crédito";
        $icon = "error";
    } finally {
        unset($conexion);
        unset($stmt);
        mover_pag($ruta, $mensaje, $icon);
    }
} else {
    if ($diasNotaC < 0) {
        $ruta = "crearNotaC.php";
        $mensaje = "La fecha de la nota crédito no puede ser menor que la actual";
        $icon = "error";
        mover_pag($ruta, $mensaje, $icon);
    }
}
?>
</body>
</html>