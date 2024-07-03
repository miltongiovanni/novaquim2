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
    <title>Ingreso de Productos a la Remisión</title>
    <meta charset="utf-8">
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<?php
$remisionOperador = new RemisionesOperaciones();
$detRemisionOperador = new DetRemisionesOperaciones();
try {
    if ($codProducto > 100000) {
        //PRODUCTOS DE DISTRIBUCIÓN
        $invDistribucionOperador = new InvDistribucionOperaciones();
        $invDistribucion = $invDistribucionOperador->getInvDistribucion($codProducto);
        if ($cantProducto > $invDistribucion) {
            $_SESSION['idRemision'] = $idRemision;
            $ruta = "../detalle-remision/";
            $mensaje = "No hay inventario suficiente";
            $icon = "warning";
        } else {
            $nvoInvDistribucion = $invDistribucion - $cantProducto;
            $datos = array($nvoInvDistribucion, $codProducto);
            $invDistribucionOperador->updateInvDistribucion($datos);
            $datos = array($idRemision, $codProducto, $cantProducto, 0, $precioProducto);
            $detRemisionOperador->makeDetRemision($datos);
            $_SESSION['idRemision'] = $idRemision;
            $ruta = "../detalle-remision/";
            $mensaje = "Detalle de la remisión adicionado con éxito";
            $icon = "success";
        }
    } else {
        //PRODUCTOS DE LA EMPRESA
        $unidades = $cantProducto;
        $invProdTerminadoOperador = new InvProdTerminadosOperaciones();
        $invTotalProdTerminado = $invProdTerminadoOperador->getInvTotalProdTerminado($codProducto);
        if ($cantProducto > $invTotalProdTerminado) {
            $_SESSION['idRemision'] = $idRemision;
            $ruta = "../detalle-remision/";
            $mensaje = "No hay inventario suficiente";
            $icon = "warning";
        } else {
            $invProdTerminado = $invProdTerminadoOperador->getInvProdTerminado($codProducto);
            for ($i = 0; $i < count($invProdTerminado); $i++) {
                $inv = $invProdTerminado[$i]['invProd'];
                $lote = $invProdTerminado[$i]['loteProd'];
                if ($inv >= $unidades) {
                    $nvoInv = $inv - $unidades;
                    $datos = array($idRemision, $codProducto, $unidades, $lote, $precioProducto);
                    $detRemisionOperador->makeDetRemision($datos);
                    $unidades = 0;
                    $datos = array($nvoInv, $codProducto, $lote);
                    $invProdTerminadoOperador->updateInvProdTerminado($datos);
                    break;
                } else {
                    $unidades = $unidades - $inv;
                    $datos = array(0, $codProducto, $lote);
                    $invProdTerminadoOperador->updateInvProdTerminado($datos);
                    $datos = array($idRemision, $codProducto, $inv, $lote, $precioProducto);
                    $detRemisionOperador->makeDetRemision($datos);
                }
            }
            $_SESSION['idRemision'] = $idRemision;
            $ruta = "../detalle-remision/";
            $mensaje = "Detalle de la remisión adicionado con éxito";
            $icon = "success";
        }
    }

} catch (Exception $e) {
    $_SESSION['idRemision'] = $idRemision;
    $ruta = "../detalle-remision/";
    $mensaje = "Error al ingresar el detalle de la remisión";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>