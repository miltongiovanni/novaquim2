<?php
include "../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
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
    <title>Actualización de pago de Facturas de Compra y de Gastos</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<?php
$datos = array($pago, $fechPago, $descuentoE, $formPago, $idEgreso);
$EgresoOperador = new EgresoOperaciones();
$egreso = $EgresoOperador->getEgreso($idEgreso);
if (isset($modEgreso) && $modEgreso == 1) {
    $abono = 0;
} else {
    $abono = $EgresoOperador->getPagoXIdTipoCompra($egreso['idCompra'], $egreso['tipoCompra']);
}
if (($abono + $pago + $descuentoE) > $egreso['vreal']) {
    $_SESSION['idEgreso'] = $idEgreso;
    $ruta = "egreso.php";
    $mensaje = "El pago sobrepasa el valor de la factura";
    $icon = "error";
    mover_pag($ruta, $mensaje, $icon);
} else {
    try {
        $EgresoOperador->updateEgreso($datos);
        if (abs($egreso['vreal'] - $pago - $descuentoE) < 100) {
            if ($egreso['tipoCompra'] == 6) {
                $GastoOperador = new GastosOperaciones();
                $GastoOperador->cancelaGasto(7, $fechPago, $egreso['idCompra']);
            } else {
                $CompraOperador = new ComprasOperaciones();
                $CompraOperador->cancelaCompra(7, $fechPago, $egreso['idCompra']);
            }
        }
        $_SESSION['idEgreso'] = $idEgreso;
        $ruta = "egreso.php";
        $mensaje = "Egreso actualizado correctamente";
        $icon = "success";
    } catch (Exception $e) {
        $_SESSION['idEgreso'] = $idEgreso;
        $ruta = "egreso.php";
        $mensaje = "Error al actualizar el egreso";
        $icon = "error";
    } finally {
        unset($conexion);
        unset($stmt);
        mover_pag($ruta, $mensaje, $icon);
    }
}
?>
</body>
</html>