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
$link = Conectar::conexion();
try {
    $error = 0;
    //COMIENZA LA TRANSACCIÓN
    $link->beginTransaction();

    //ESTA PARTE ES PARA EL CONSECUTIVO DEL LOTE
    $OProdColorOperador = new OProdColorOperaciones();
    $loteColor = $OProdColorOperador->getLastLote() + 1;
    $FormulaColorOperador = new FormulasColorOperaciones();
    $codColor= $FormulaColorOperador->getCodSolucionByFormulaColor($idFormulaColor);
    $datos = array($loteColor, $fechProd, $idFormulaColor, $cantKg, $codPersonal, $codColor);
    $qry = "INSERT INTO ord_prod_col (loteColor, fechProd, idFormulaColor, cantKg, codPersonal, codColor) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $link->prepare($qry);
    $stmt->execute($datos);
    $DetFormulaColorOperador = new DetFormulaColorOperaciones();
    $InvMPrimaOperador = new InvMPrimasOperaciones();
    $MPrimaOperador = new MPrimasOperaciones();
    $detalleFormulaColor = $DetFormulaColorOperador->getDetalleFormulaColor($idFormulaColor);
    for ($i = 0; $i < count($detalleFormulaColor); $i++) {
        $uso = $cantKg * $detalleFormulaColor[$i]['porcentaje'];
        $codMPrima = $detalleFormulaColor[$i]['codMPrima'];
        if ($codMPrima == 10401) {
            $uso = $uso * 1.015;
        }
        $invTotalMPrima = $InvMPrimaOperador->getInvTotalMPrima($codMPrima);
        if ($invTotalMPrima < $uso) {
            //SI NO HAY EXISTENCIAS DE MATERIA PRIMA SE CANCELA LA TRANSACCIÓN
            /* Rollback */
            $link->rollBack();
            $ruta = "crearOProdColor.php";
            $materiaPrima = $MPrimaOperador->getNomMPrima($codMPrima);
            $mensaje = "No hay inventario suficiente de " . $materiaPrima . " hay " . round($invTotalMPrima, 2) . " Kg";
            mover_pag($ruta, $mensaje, $icon);
            break;
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
                    $qryDOP = "INSERT INTO det_ord_prod_col (loteColor, codMPrima, cantMPrima, loteMPrima) VALUES ($loteColor, $codMPrima, $uso1, '$loteMP')";
                    $stmt = $link->prepare($qryDOP);
                    $stmt->execute();
                    break;
                } else {
                    $uso1 = $uso1 - $invMP;
                    $qryupt = "UPDATE inv_mprimas SET invMP=0 WHERE loteMP='$loteMP' and codMP=$codMPrima";
                    $stmt = $link->prepare($qryupt);
                    $stmt->execute();
                    if ($invMP > 0) {
                        $qryDOP = "INSERT INTO det_ord_prod_col (loteColor, codMPrima, cantMPrima, loteMPrima) VALUES ($loteColor, $codMPrima, $invMP, '$loteMP')";
                        $stmt = $link->prepare($qryDOP);
                        $stmt->execute();
                    }
                }
            }
        }
    }
    $link->commit();
    $_SESSION['loteColor'] = $loteColor;
    $ruta = "detO_Prod_col.php";
    $mensaje = "Orden de Producción de Color Creada correctamente";
} catch (Exception $e) {
    //echo $e->getMessage();
    //Rollback the transaction.
    $link->rollBack();
    $ruta = "crearOProdColor.php";
    $mensaje = "Error al crear la Orden de Producción de Color";
} finally {
    mover_pag($ruta, $mensaje, $icon);
}
