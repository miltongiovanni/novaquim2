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
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Actualizar detalle del gasto</title>
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<?php
$GastoOperador = new GastosOperaciones();
$DetGastoOperador = new DetGastosOperaciones();
$detalle = $DetGastoOperador->getDetGasto($idGasto, $producto);
try {
    $datos = array($cantGasto, $precGasto, $codIva, $idGasto, $producto);
    $DetGastoOperador->updateDetGasto($datos);
    $GastoOperador->updateTotalesGasto(BASE_C, BASE_C2, BASE_C3, BASE_C4, $idGasto);
    $_SESSION['idGasto'] = $idGasto;
    $ruta = "../detalle/";
    $mensaje = "Detalle de gasto actualizado con éxito";
    $icon = "success";
} catch (Exception $e) {
    $_SESSION['idGasto'] = $idGasto;
    $ruta = "../detalle/";
    $mensaje = "Error al actualizar el detalle del gasto";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>