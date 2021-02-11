<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

//ESTOS SON LOS DATOS QUE RECIBE DE LA ORDEN DE PRODUCCIÓN

foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if(is_array($valor)){
        //echo $nombre_campo.print_r($valor).'<br>';
    }else{
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Orden de Producción</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<?php
$link = Conectar::conexion();
try {
    $error = 0;
    //COMIENZA LA TRANSACCIÓN
    $link->beginTransaction();

    //ESTA PARTE ES PARA EL CONSECUTIVO DEL LOTE
    $OProdOperador = new OProdOperaciones();
    $lote = $OProdOperador->getLastLote() + 1;
    $estado = 2;
    $datos = array($lote, $fechProd, $idFormula, $cantidadKg, $codResponsable, $codProducto, $estado);
    $qry = "INSERT INTO ord_prod (lote, fechProd, idFormula, cantidadKg, codResponsable, codProducto, estado) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $link->prepare($qry);
    $stmt->execute($datos);
    $DetFormulaOperador = new DetFormulaOperaciones();
    $InvMPrimaOperador = new InvMPrimasOperaciones();
    $MPrimaOperador = new MPrimasOperaciones();
    $detalleFormula = $DetFormulaOperador->getDetalleFormula($idFormula);
    for ($i = 0; $i < count($detalleFormula); $i++) {
        $uso = $cantidadKg * $detalleFormula[$i]['porcentaje'];
        $codMPrima = $detalleFormula[$i]['codMPrima'];
        $orden = $detalleFormula[$i]['orden'];
        if ($codMPrima == 10401) {
            $uso = $uso * 1.015;
        }
        $invTotalMPrima = $InvMPrimaOperador->getInvTotalMPrima($codMPrima);
        if ($invTotalMPrima < $uso) {
            //SI NO HAY EXISTENCIAS DE MATERIA PRIMA SE CANCELA LA TRANSACCIÓN
            /* Rollback */
            $link->rollBack();
            $ruta = "crearOProd.php";
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
                    $qryDOP = "INSERT INTO det_ord_prod (lote, codMPrima, cantidadMPrima, loteMP, orden) VALUES ($lote, $codMPrima, $uso1, '$loteMP', $orden)";
                    $stmt = $link->prepare($qryDOP);
                    $stmt->execute();
                    break;
                } else {
                    $uso1 = $uso1 - $invMP;
                    $qryupt = "UPDATE inv_mprimas SET invMP=0 WHERE loteMP='$loteMP' and codMP=$codMPrima";
                    $stmt = $link->prepare($qryupt);
                    $stmt->execute();
                    if ($invMP > 0) {
                        $qryDOP = "INSERT INTO det_ord_prod (lote, codMPrima, cantidadMPrima, loteMP, orden) VALUES ($lote, $codMPrima, $invMP, '$loteMP', $orden)";
                        $stmt = $link->prepare($qryDOP);
                        $stmt->execute();
                    }
                }
            }
        }
    }
    $link->commit();
    $_SESSION['lote'] = $lote;
    $ruta = "detO_Prod.php";
    $mensaje = "Orden de Producción Creada correctamente";
    $icon = "success";
} catch (Exception $e) {
    //echo $e->getMessage();
    //Rollback the transaction.
    $link->rollBack();
    $ruta = "crearOProd.php";
    $mensaje = "Error al crear la Orden de Producción";
    $icon = "error";
} finally {
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>
