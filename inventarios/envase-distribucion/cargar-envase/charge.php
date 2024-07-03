<?php
include "../../../includes/valAcc.php";

function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Cargar Envase como Producto de Distribución</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<?php
$invDistribucionOperador = new InvDistribucionOperaciones();
$relEnvDisOperador = new RelEnvDisOperaciones();
$invEnvaseOperador = new InvEnvasesOperaciones();
$invTapaOperador = new InvTapasOperaciones();
$idDis = $_POST['idDis'];
$unidades = $_POST['unidades'];

$relacionEnvDis = $relEnvDisOperador->getRelEnvDisByidDis($idDis);
$invEnvase = $invEnvaseOperador->getInvEnvase($relacionEnvDis['codEnvase']);
$invTapa = $invTapaOperador->getInvTapas($relacionEnvDis['codTapa']);

try {
    if (($invTapa >= $unidades) && ($invEnvase >= $unidades)) {
        $invDistribucion = $invDistribucionOperador->getInvDistribucion($relacionEnvDis['idDis']);
        $nvoInvDistribucion = $invDistribucion + $unidades;
        $datos = array($nvoInvDistribucion, $relacionEnvDis['idDis']);
        $invDistribucionOperador->updateInvDistribucion($datos);

        $nvoInvEnvase = $invEnvase - $unidades;
        $datos = array($nvoInvEnvase, $relacionEnvDis['codEnvase']);
        $invEnvaseOperador->updateInvEnvase($datos);

        $nvoInvTapas = $invTapa - $unidades;
        $datos = array($nvoInvTapas, $relacionEnvDis['codTapa']);
        $invTapaOperador->updateInvTapas($datos);

        $ruta = "../../../menu.php";
        $mensaje = "Carga de envase como producto de distribución realizado con éxito";
        $icon = "success";
    } else {
        $ruta = "../cargar-envase/";
        $mensaje = "No hay inventario suficiente de Envases o Tapa";
        $icon = "warning";
    }

} catch (Exception $e) {
    $ruta = "../cargar-envase/";
    $mensaje = "Error al cargar el envase como producto de distribución";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>
