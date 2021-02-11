<?php
include "../includes/valAcc.php";
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
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <title>Seleccionar Producto a Envasar</title>
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>

</head>
<body>
<?php
//Envasado
$link = Conectar::conexion();
$EnvasadoDistOperador = new EnvasadoDistOperaciones();
$RelDisMPrimaOperador = new RelDisMPrimaOperaciones();
$relDisMPrima = $RelDisMPrimaOperador->getRelEnvDisXDis($codDist);
try {
    //COMIENZA LA TRANSACCIÓN
    $link->beginTransaction();
    //SE INSERTA LA CANTIDAD DE PRODUCTO DE DISTRIBUCION ENVASADO
    $datos = array($fechaEnvDist, $codDist, $cantidad);
    $qry = "INSERT INTO envasado_dist (fechaEnvDist, codDist, cantidad)VALUES(?, ?, ?)";
    $stmt = $link->prepare($qry);
    $stmt->execute($datos);
    //SE CARGA EN EL INVENTARIO
    $InvDistOperador = new InvDistribucionOperaciones();
    $invDist = $InvDistOperador->getInvDistribucion($codDist);
    if ($invDist >= 0) {
        $invDist = $invDist + $cantidad;
        $datos = array($invDist, $codDist);
        $qry = "UPDATE inv_distribucion SET invDistribucion=? WHERE codDistribucion=?";
        $stmt = $link->prepare($qry);
        $stmt->execute($datos);
    } else {
        $datos = array($codDist, $cantidad);
        $qry = "INSERT INTO inv_distribucion (codDistribucion, invDistribucion) VALUES(?, ?)";
        $stmt = $link->prepare($qry);
        $stmt->execute($datos);
    }
    //SE DESCUENTA EL ENVASE
    $InvEnvaseOperador = new InvEnvasesOperaciones();
    $codEnvase = $relDisMPrima['codEnvase'];
    $invEnvase = $InvEnvaseOperador->getInvEnvase($codEnvase);
    if ($invEnvase >= $cantidad) {
        $nvoInvEnvase = $invEnvase - $cantidad;
        $qryupt = "UPDATE inv_envase SET invEnvase=$nvoInvEnvase WHERE codEnvase=$codEnvase";
        $stmt = $link->prepare($qryupt);
        $stmt->execute();
    } else {
        $link->rollBack();
        $ruta = "env_dist.php";
        $mensaje = "No hay envase suficiente solo hay '.$invEnvase.' unidades";
        $icon = "warning";
        mover_pag($ruta, $mensaje, $icon);
        exit;
    }
    //SE DESCUENTA LA TAPA
    $InvTapaOperador = new InvTapasOperaciones();
    $codTapa = $relDisMPrima['codTapa'];
    $invTapa = $InvTapaOperador->getInvTapas($codTapa);
    if ($invTapa >= $cantidad) {
        $nvoInvTapa = $invTapa - $cantidad;
        $qryupt = "UPDATE inv_tapas_val SET invTapa=$nvoInvTapa WHERE codTapa=$codTapa";
        $stmt = $link->prepare($qryupt);
        $stmt->execute();
    } else {
        $link->rollBack();
        $ruta = "env_dist.php";
        $mensaje = "No hay tapas o válvulas suficientes, sólo hay '.$invTapa.' unidades";
        $icon = "warning";
        mover_pag($ruta, $mensaje, $icon);
        exit;
    }
    //SE DESCUENTA EL INVENTARIO DE MATERIA PRIMA
    $codMPrima = $relDisMPrima['codMPrima'];
    $densidad = $relDisMPrima['densidad'];
    $codMedida = $relDisMPrima['codMedida'];
    $MPrimaOperador = new MPrimasOperaciones();
    $MedidaOperador = new MedidasOperaciones();
    $InvMPrimaOperador = new InvMPrimasOperaciones();
    $medida = $MedidaOperador->getMedida($codMedida);
    $uso = $medida['cantMedida'] * $cantidad * $densidad / 1000;

    $invTotalMPrima = $InvMPrimaOperador->getInvTotalMPrima($codMPrima);
    if ($invTotalMPrima < $uso) {
        //SI NO HAY EXISTENCIAS DE MATERIA PRIMA SE CANCELA LA TRANSACCIÓN
        /* Rollback */
        $link->rollBack();
        $ruta = "env_dist.php";
        $materiaPrima = $MPrimaOperador->getNomMPrima($codMPrima);
        $mensaje = "No hay inventario suficiente de " . $materiaPrima . " hay " . round($invTotalMPrima, 2) . " Kg";
        $icon = "warning";
        mover_pag($ruta, $mensaje, $icon);
        exit;
    } else {
        $uso1 = $uso;
        $invMPrima = $InvMPrimaOperador->getInvMPrima($codMPrima);
        for ($j = 0; $j < count($invMPrima); $j++) {
            $invMP = $invMPrima[$j]['invMP'];
            $loteMP = $invMPrima[$j]['loteMP'];
            $fechLote = $invMPrima[$j]['fechLote'];
            if ($invMP >= $uso1) {
                $invMP = $invMP - $uso1;
                $qryupt = "UPDATE inv_mprimas SET invMP=$invMP WHERE loteMP='$loteMP' and codMP=$codMPrima";
                $stmt = $link->prepare($qryupt);
                $stmt->execute();
            } else {
                $uso1 = $uso1 - $invMP;
                $qryupt = "UPDATE inv_mprimas SET invMP=0 WHERE loteMP='$loteMP' and codMP=$codMPrima";
                $stmt = $link->prepare($qryupt);
                $stmt->execute();
            }
        }
    }
    $link->commit();
    $ruta = "../menu.php";
    $mensaje = "Productos Cargados correctamente";
    $icon = "success";
} catch (Exception $e) {
    //echo $e->getMessage();
    //Rollback the transaction.
    $link->rollBack();
    $ruta = "env_dist.php";
    $mensaje = "Error al empacar los productos de distribución";
    $icon = "error";
} finally {
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>