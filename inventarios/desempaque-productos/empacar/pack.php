<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$codUnidad = $_POST['codUnidad'];
$unidades = $_POST['unidades'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Organizar Unidades en Pacas</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<?php
$invDistribucionOperador = new InvDistribucionOperaciones();
$invUnidad = $invDistribucionOperador->getInvDistribucion($codUnidad);
$relDisEmpOperador = new RelDisEmpOperaciones();
$paca = $relDisEmpOperador->getPacaByUnidad($codUnidad);
$noPacas = intval($unidades / $paca['cantidad']);

try {
    if($unidades>$invUnidad){
        $ruta = "empacar.php";
        $mensaje = "No hay inventario suficiente de producto";
        $icon = "warning";
    }else{
        if ($unidades >= $paca['cantidad']) {
            $invPaca = $invDistribucionOperador->getInvDistribucion($paca['codPaca']);
            $nvoInvUnidades = $invUnidad - $noPacas * $paca['cantidad'];
            $datos = array($nvoInvUnidades, $codUnidad);
            $invDistribucionOperador->updateInvDistribucion($datos);
            $nvoInvPacas = $invPaca + $noPacas;
            $datos = array($nvoInvPacas, $paca['codPaca']);
            $invDistribucionOperador->updateInvDistribucion($datos);
            $ruta = "../menu.php";
            $mensaje = "Empaque de Producto realizado con Éxito";
            $icon = "success";
        } else {
            $ruta = "empacar.php";
            $mensaje = "El número de unidades no completa una paca";
            $icon = "warning";
        }
    }


} catch (Exception $e) {
    $ruta = "desempacar.php";
    $mensaje = "Error al desempacar el producto";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>


