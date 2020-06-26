<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

foreach ($_POST as $nombre_campo => $valor) {
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
    //echo $nombre_campo." = ".$valor."<br>";
    eval($asignacion);
}
// $Cod_kit,  $Cantidad, $Fecha
//Envasado
$link = Conectar::conexion();
try {
    //COMIENZA LA TRANSACCIÓN
    $link->beginTransaction();
    $KitOperador = new KitsOperaciones();
    $kit = $KitOperador->getKit($codKit);
    $codEnvase = $kit['codEnvase'];
    $codigo = $kit['codigo'];
    $InvEnvaseOperador = new InvEnvasesOperaciones();
    $EnvaseOperador = new EnvasesOperaciones();
    $invEnvase = $InvEnvaseOperador->getInvEnvase($codEnvase);
    if ($invEnvase >= $cantArmado) {
        $invEnvaseNvo = $invEnvase - $cantArmado;
        $qryupt = "UPDATE inv_envase SET invEnvase=$invEnvaseNvo WHERE codEnvase=$codEnvase";
        $stmt = $link->prepare($qryupt);
        $stmt->execute();
    } else {
        $link->rollBack();
        $ruta = "arm_kits.php";
        $nomEnvase = $EnvaseOperador->getNomEnvase($codEnvase);
        $mensaje = "No hay inventario suficiente de " . $nomEnvase . " solo hay " . round($invEnvase, 0) . " unidades";
        mover_pag($ruta, $mensaje);
    }
    $DetKitOperador = new DetKitsOperaciones();
    $detKit = $DetKitOperador->getTableDetKits($codKit);
    for ($i = 0; $i < count($detKit); $i++) {
        $codProducto = $detKit[$i]['codProducto'];
        if ($codProducto < 100000) {
            //PRODUCTO NOVAQUIM
            $InvProdTerminadoOperador = new InvProdTerminadosOperaciones();
            $PresentacionOperador = new PresentacionesOperaciones();
            $invProdTerminado = $InvProdTerminadoOperador->getInvTotalProdTerminado($codProducto);
            if ($invProdTerminado >= $cantArmado) {
                $unidades = $cantArmado;
                $invPresentaciones = $InvProdTerminadoOperador->getInvProdTerminado($codProducto);
                for ($j = 0; $j < count($invPresentaciones); $j++) {
                    $invProd = $invPresentaciones[$j]['invProd'];
                    $i = $i + 1;
                    $loteProd = $invPresentaciones[$j]['loteProd'];
                    $codPresentacion = $invPresentaciones[$j]['codPresentacion'];
                    if (($invProd >= $unidades)) {
                        $invProd = $invProd - $unidades;
                        /*SE ACTUALIZA EL INVENTARIO*/
                        $qryupt = "UPDATE inv_prod SET invProd=$invProd WHERE loteProd=$loteProd AND codPresentacion=$codPresentacion";
                        $stmt = $link->prepare($qryupt);
                        $stmt->execute();
                    } else {
                        $unidades = $unidades - $invProd;
                        //SE ELIMINA DEL INVENTARIO  Aqui se prodria borrar del inventario
                        $qry = "UPDATE inv_prod SET invProd=0 WHERE loteProd=$loteProd AND codPresentacion=$codPresentacion";
                        $stmt = $link->prepare($qry);
                        $stmt->execute();
                    }
                }
            } else {
                $link->rollBack();
                $ruta = "arm_kits.php";
                $nomProductoTerminado = $PresentacionOperador->getNamePresentacion($codProducto);
                $mensaje = "No hay inventario suficiente de " . $nomProductoTerminado . " solo hay " . round($invProdTerminado, 0) . " unidades";
                mover_pag($ruta, $mensaje);
            }
        } else {
            //PRODUCTO DE DISTRIBUCION
            $InvDistribucionOperador = new InvDistribucionOperaciones();
            $ProdDistribucionOperador = new ProductosDistribucionOperaciones();
            $invDist = $InvDistribucionOperador->getInvDistribucion($codProducto);
            $unidades = $cantArmado;
            if ($invDist >= $unidades) {
                $invDist = $invDist - $unidades;
                $qryupt = "UPDATE inv_distribucion SET invDistribucion=$invDist WHERE codDistribucion=$codProducto";
                $stmt = $link->prepare($qryupt);
                $stmt->execute();
            } else {
                $link->rollBack();
                $ruta = "arm_kits.php";
                $nomProdDistribucion = $ProdDistribucionOperador->getNomProductoDistribucion($codProducto);
                $mensaje = "No hay inventario suficiente de " . $nomProdDistribucion . " solo hay " . round($invDist, 0) . " unidades";
                mover_pag($ruta, $mensaje);
            }
        }
    }
    //CARGAR LOS KITS
    if ($codigo < 100000) {
        //PRODUCTOS DE LA EMPRESA
        $invProdTerminado = $InvProdTerminadoOperador->getInvTotalProdTerminado($codigo);
        if ($invProdTerminado) {
            $invProdTerminado = $invProdTerminado + $cantArmado;
            $qryupt = "UPDATE inv_prod SET invProd=$invProdTerminado WHERE loteProd=0 AND codPresentacion=$codigo";
            $stmt = $link->prepare($qryupt);
            $stmt->execute();
        } else {
            $qryins = "INSERT INTO inv_prod (codPresentacion, loteProd, invProd) VALUES ($codigo, 0, $cantArmado)";
            $stmt = $link->prepare($qryins);
            $stmt->execute();
        }
    } else {
        //PRODUCTOS DE DISTRIBUCION
        $invDist = $InvDistribucionOperador->getInvDistribucion($codigo);
        if ($invDist) {
            $invDist = $invDist + $cantArmado;
            $qryupt = "UPDATE inv_distribucion SET invDistribucion=$invDist WHERE codDistribucion=$codigo";
            $stmt = $link->prepare($qryupt);
            $stmt->execute();
        } else {
            $qryins = "INSERT INTO inv_distribucion (codDistribucion, invDistribucion) VALUES ($codigo, $cantArmado)";
            $stmt = $link->prepare($qryins);
            $stmt->execute();
        }
    }
    //SE CARGA A LA TABLA
    $qryins_kit = "INSERT INTO arm_kit (codKit, cantArmado, fechArmado) VALUES ($codKit, $cantArmado, '$fechArmado')";
    $stmt = $link->prepare($qryins_kit);
    $stmt->execute();
    //SE REALIZA EL COMMIT
    $link->commit();
    $ruta = "listar_arm_kits.php";
    $mensaje = "Kit Creados y Cargados con Éxito";
} catch (Exception $e) {
    //echo $e->getMessage();
    //Rollback the transaction.
    $link->rollBack();
    $ruta = "arm_kits.php";
    $mensaje = "Error al armar los kits";
} finally {
    mover_pag($ruta, $mensaje);
}



