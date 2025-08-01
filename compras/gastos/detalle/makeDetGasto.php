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
        //echo $nombre_campo.print_r($valor).'<br>';
    } else {
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Ingreso del Detalle de los Gastos de Industrias Novaquim</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<?php
$GastoOperador = new GastosOperaciones();
$DetGastoOperador = new DetGastosOperaciones();
if ($DetGastoOperador->productoExiste($idGasto, $producto)) {
    $_SESSION['idGasto'] = $idGasto;
    $ruta = "../detalle/";
    $mensaje = "Producto incluido anteriormente";
    $icon = "error";
    mover_pag($ruta, $mensaje, $icon);
} else {
    $datos = array($idGasto, $producto, $cantGasto, $precGasto, $codIva);
    try {
        $DetGastoOperador->makeDetGasto($datos);
        $GastoOperador->updateTotalesGasto(BASE_C, BASE_C2, BASE_C3, BASE_C4, $idGasto);
        $_SESSION['idGasto'] = $idGasto;
        $ruta = "../detalle/";
        $mensaje = "Detalle de gasto adicionado con éxito";
        $icon = "success";
    } catch (Exception $e) {
        $_SESSION['idGasto'] = $idGasto;
        $ruta = "../detalle/";
        $mensaje = "Error al ingresar el detalle de la factura de compra";
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