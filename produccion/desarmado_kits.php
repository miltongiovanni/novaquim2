<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if(is_array($valor)){
        //echo $nombre_campo.print_r($valor).'<br>';
    }else{
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
// $Cod_kit,  $cantDesarmado, $Fecha
//Envasado
try {
    $link = Conectar::conexion();

//COMIENZA LA TRANSACCIÓN
    $link->beginTransaction();
    $KitOperador = new KitsOperaciones();
    $kit = $KitOperador->getKit($codKit);
    $codEnvase = $kit['codEnvase'];
    $codigo = $kit['codigo'];

    /*REVISAR SI HAY INVENTARIO SUFICIENTE PARA DESCARGAR*/
    if ($codigo > 100000) {
        $InvDistribucionOperador = new InvDistribucionOperaciones();
        $ProdDistribucionOperador = new ProductosDistribucionOperaciones();
        $inv_bus = $InvDistribucionOperador->getInvDistribucion($codigo);
        $nomProd = $ProdDistribucionOperador->getNomProductoDistribucion($codigo);
    } else {
        $InvProdTerminadoOperador = new InvProdTerminadosOperaciones();
        $PresentacionOperador = new PresentacionesOperaciones();
        $inv_bus = $InvProdTerminadoOperador->getInvTotalProdTerminado($codigo);
        $nomProd = $PresentacionOperador->getNamePresentacion($codigo);
    }
    if ($inv_bus < $cantDesarmado) {
        $link->rollBack();
        $ruta = "desarm_kits.php";
        $mensaje = "No hay inventario suficiente de " . $nomProd . " solo hay " . round($inv_bus, 0) . " unidades";
        mover_pag($ruta, $mensaje);
    } else {
        //SE DESCUENTA LA CANTIDAD DE KITS
        if ($codigo < 100000) {
            //SI EL KIT ES PRODUCTO DE LA EMPRESA
            $unidades = $cantDesarmado;
            $invPresentaciones = $InvProdTerminadoOperador->getInvProdTerminado($codigo);
            for ($j = 0; $j < count($invPresentaciones); $j++) {
                $invProd = $invPresentaciones[$j]['invProd'];
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
            //SI EL KIT ES PRODUCTO DE DISTRIBUCION
            $invDist = $InvDistribucionOperador->getInvDistribucion($codProducto);
            $invDist = $invDist - $cantDesarmado;
            $qryupt = "UPDATE inv_distribucion SET invDistribucion=$invDist WHERE codDistribucion=$codigo";
            $stmt = $link->prepare($qryupt);
            $stmt->execute();
        }
    }
//SE CARGA EL ENVASE
    $InvEnvaseOperador = new InvEnvasesOperaciones();
    $invEnvase = $InvEnvaseOperador->getInvEnvase($codEnvase);
    $invEnvase = $invEnvase + $cantDesarmado;
    $qryupt = "UPDATE inv_envase SET invEnvase=$invEnvase WHERE codEnvase=$codEnvase";
    $stmt = $link->prepare($qryupt);
    $stmt->execute();
//SE CARGA EL DETALLE DE KIT
    $DetKitOperador = new DetKitsOperaciones();
    $detKit = $DetKitOperador->getTableDetKits($codKit);
    for ($i = 0; $i < count($detKit); $i++) {
        $codProducto = $detKit[$i]['codProducto'];
        if ($codProducto < 100000) {
            //PRODUCTO NOVAQUIM
            $InvProdTerminadoOperador = new InvProdTerminadosOperaciones();
            $invProdTerminado = $InvProdTerminadoOperador->getMaxLoteInvProdTerminado($codProducto);
            $loteProd = $invProdTerminado['loteProd'];
            $invProd = $invProdTerminado['invProd'];
            $invProd += $cantDesarmado;
            /*SE ACTUALIZA EL INVENTARIO*/
            $qryupt = "UPDATE inv_prod SET invProd=$invProd WHERE loteProd=$loteProd AND codPresentacion=$codProducto";
            $stmt = $link->prepare($qryupt);
            $stmt->execute();
        } else {
            //PRODUCTO DE DISTRIBUCION
            $InvDistribucionOperador = new InvDistribucionOperaciones();
            $invDist = $InvDistribucionOperador->getInvDistribucion($codProducto);
            $invDist += $cantDesarmado;
            $qryupt = "UPDATE inv_distribucion SET invDistribucion=$invDist WHERE codDistribucion=$codProducto";
            $stmt = $link->prepare($qryupt);
            $stmt->execute();
        }
    }

//SE CARGA A LA TABLA
    $qryins_kit = "INSERT INTO desarm_kit (codKit, cantDesarmado, fechDesarmado) values ($codKit, $cantDesarmado, '$fechDesarmado')";
    $stmt = $link->prepare($qryins_kit);
    $stmt->execute();
//SE REALIZA EL COMMIT
    $link->commit();
    $ruta = "listar_desarm_kits.php";
    $mensaje = "Kit desarmados con éxito";

} catch (Exception $e) {
    //echo $e->getMessage();
    //Rollback the transaction.
    $link->rollBack();
    $ruta = "desarm_kits.php";
    $mensaje = "Error al desarmar los kits";
} finally {
    mover_pag($ruta, $mensaje);
}

?>