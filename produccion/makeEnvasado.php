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
$OProdOperador = new OProdOperaciones();
$ordenProd = $OProdOperador->getOProd($lote);
$EnvasadoOperador = new EnvasadoOperaciones();
try {
    $error = 0;
    //COMIENZA LA TRANSACCIÓN
    $link->beginTransaction();
    $volumenEnvasado = $EnvasadoOperador->getVolumenEnvasado($codPresentacion, $cantPresentacion);
    if (($cantidadPendiente - $volumenEnvasado) < -($ordenProd['cantidadKg']*0.05/($ordenProd['densMin']+ $ordenProd['densMax']))) {
        $link->rollBack();
        $_SESSION['lote'] = $lote;
        $ruta = "det_Envasado.php";
        $mensaje = "No se puede envasar la presentación del producto, se necesita " . round($volumenEnvasado, 2) . " litros y sólo hay " . round($cantidadPendiente, 2) . " litros";
        mover_pag($ruta, $mensaje);
    } else {
        //SE INSERTA LA CANTIDAD DE PRODUCTO ENVASADO

        $datos = array($lote, $codPresentacion, $cantPresentacion);
        $qry = "INSERT INTO envasado (lote, codPresentacion, cantPresentacion)VALUES(?, ?, ?)";
        $stmt = $link->prepare($qry);
        $stmt->execute($datos);
        $OperadorPresentacion = new PresentacionesOperaciones();
        $presentacion = $OperadorPresentacion->getPresentacion($codPresentacion);
        //Envase
        $InvEnvaseOperador = new InvEnvasesOperaciones();
        $codEnvase = $presentacion['codEnvase'];
        $invEnvase = $InvEnvaseOperador->getInvEnvase($codEnvase);

        if ($invEnvase >= $cantPresentacion) {
            $nvoInvEnvase = $invEnvase - $cantPresentacion;
            $qryupt = "UPDATE inv_envase SET invEnvase=$nvoInvEnvase WHERE codEnvase=$codEnvase";
            $stmt = $link->prepare($qryupt);
            $stmt->execute();
        } else {
            $link->rollBack();
            $_SESSION['lote'] = $lote;
            $ruta = "det_Envasado.php";
            $mensaje = "No hay envase suficiente solo hay '.$invEnvase.' unidades";
            mover_pag($ruta, $mensaje);
        }
        //Tapa
        $InvTapaOperador = new InvTapasOperaciones();
        $codTapa = $presentacion['codTapa'];
        $invTapa = $InvTapaOperador->getInvTapas($codTapa);

        if ($invTapa >= $cantPresentacion) {
            $nvoInvTapa = $invTapa - $cantPresentacion;
            $qryupt = "UPDATE inv_tapas_val SET invTapa=$nvoInvTapa WHERE codTapa=$codTapa";
            $stmt = $link->prepare($qryupt);
            $stmt->execute();
        } else {
            $link->rollBack();
            $_SESSION['lote'] = $lote;
            $ruta = "det_Envasado.php";
            $mensaje = "No hay tapas o válvulas suficientes, sólo hay '.$invTapa.' unidades";
            mover_pag($ruta, $mensaje);
        }
        //Etiqueta
        $InvEtiquetaOperador = new InvEtiquetasOperaciones();
        $codEtiq = $presentacion['codEtiq'];
        $invEtiq = $InvEtiquetaOperador->getInvEtiqueta($codEtiq);
        if ($invEtiq >= $cantPresentacion) {
            $nvoInvEtiq = $invEtiq - $cantPresentacion;
            $qryupt = "UPDATE inv_etiquetas SET invEtiq=$nvoInvEtiq WHERE codEtiq=$codEtiq";
            $stmt = $link->prepare($qryupt);
            $stmt->execute();
        } else {
            $link->rollBack();
            $_SESSION['lote'] = $lote;
            $ruta = "det_Envasado.php";
            $mensaje = "No hay etiquetas suficientes, sólo hay '.$invEtiq.' unidades";
            mover_pag($ruta, $mensaje);
        }

        ///Se deja el estado en 3 que es parcialmente envasado
        $datos= array(3, $lote);
        $qry = "UPDATE ord_prod SET estado=? WHERE lote=?";
        $stmt = $link->prepare($qry);
        $stmt->execute($datos);
        $link->commit();
        $_SESSION['lote'] = $lote;
        $ruta = "det_Envasado.php";
        $mensaje = "Envasado creado correctamente";
    }

} catch (Exception $e) {
    //echo $e->getMessage();
    //Rollback the transaction.
    $link->rollBack();
    $_SESSION['lote'] = $lote;
    $ruta = "det_Envasado.php";
    $mensaje = "Error al envasar el producto";
} finally {
    mover_pag($ruta, $mensaje);
}


