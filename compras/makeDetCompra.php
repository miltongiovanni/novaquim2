<?php
include "../includes/valAcc.php";
include "../includes/calcularDias.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

foreach ($_POST as $nombre_campo => $valor) {
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
    //echo $nombre_campo . " = " . $valor . "<br>";
    eval($asignacion);
}
$CompraOperador = new ComprasOperaciones();
$DetCompraOperador = new DetComprasOperaciones();
if ($DetCompraOperador->productoExiste($idCompra, $codigo)) {
    echo ' <script >
				alert("Producto incluido anteriormente");
				history.back();
			</script>';
} else {
    if ($tipoCompra == 1) {
        $datos = array($idCompra, $codigo, $cantidad, $precio, $lote);
    } else {
        $datos = array($idCompra, $codigo, $cantidad, $precio);
    }
    try {
        $DetCompraOperador->makeDetCompra($tipoCompra, $datos);
        $CompraOperador->updateTotalesCompra($tipoCompra, BASE_C, $idCompra);
        if ($tipoCompra == 1) {
            $InvMPrimasOperador = new InvMPrimasOperaciones();
            $invActual = $InvMPrimasOperador->getInvMPrima($codigo, $lote);
            if($invActual==0 || $invActual==null){
                $datos = array($codigo, $lote, $cantidad, $fechLote);
                $InvMPrimasOperador->makeInvMPrima($datos);
            }
            else{
                $nvoInv=$invActual+$cantidad;
                $datos = array($nvoInv, $codigo, $lote);
                $InvMPrimasOperador->updateInvMPrima($datos);
            }
            $MPrimasOperador = new MPrimasOperaciones();
            $precioActual = $MPrimasOperador->getPrecioMPrima($codigo);
            if ($precio > $precioActual) {
                $datos = array($precio, $codigo);
                $MPrimasOperador->updatePrecioMPrima($datos);
            }
        }
        if($tipoCompra == 2){
            if($codigo < 100){//Envase
                $InvEnvaseOperador = new InvEnvasesOperaciones();
                $invActual = $InvEnvaseOperador->getInvEnvase($codigo);
                if($invActual==0 || $invActual==null){
                    $datos = array($codigo, $cantidad);
                    $InvEnvaseOperador->makeInvEnvase($datos);
                }
                else{
                    $nvoInv=$invActual+$cantidad;
                    $datos = array($nvoInv, $codigo);
                    $InvEnvaseOperador->updateInvEnvase($datos);
                }
                $EnvaseOperador = new EnvasesOperaciones();
                $precioActual = $EnvaseOperador->getPrecioEnvase($codigo);
                if ($precio > $precioActual) {
                    $datos = array($precio, $codigo);
                    $EnvaseOperador->updatePrecioEnvase($datos);
                }
            }
            else{ //tapas
                $InvTapasOperador = new InvTapasOperaciones();
                $invActual = $InvTapasOperador->getInvTapas($codigo);
                if($invActual==0 || $invActual==null){
                    $datos = array($codigo, $cantidad);
                    $InvTapasOperador->makeInvTapas($datos);
                }
                else{
                    $nvoInv=$invActual+$cantidad;
                    $datos = array($nvoInv, $codigo);
                    $InvTapasOperador->updateInvTapas($datos);
                }
                $TapasOperador = new TapasOperaciones();
                $precioActual = $TapasOperador->getPrecioTapa($codigo);
                if ($precio > $precioActual) {
                    $datos = array($precio, $codigo);
                    $TapasOperador->updatePrecioTapa($datos);
                }
            }
        }
        if($tipoCompra == 3){
            $InvEtiquetaOperador = new InvEtiquetasOperaciones();
            $invActual = $InvEtiquetaOperador->getInvEtiqueta($codigo);
            if($invActual==0 || $invActual==null){
                $datos = array($codigo, $cantidad);
                $InvEtiquetaOperador->makeInvEtiqueta($datos);
            }
            else{
                $nvoInv=$invActual+$cantidad;
                $datos = array($nvoInv, $codigo);
                $InvEtiquetaOperador->updateInvEtiqueta($datos);
            }
            $EtiquetaOperador = new EtiquetasOperaciones();
            $precioActual = $EtiquetaOperador->getPrecioEtiqueta($codigo);
            if ($precio > $precioActual) {
                $datos = array($precio, $codigo);
                $EtiquetaOperador->updatePrecioEtiqueta($datos);
            }
        }
        if($tipoCompra == 5){
            $InvDistribucionOperador = new InvDistribucionOperaciones();
            $invActual = $InvDistribucionOperador->getInvDistribucion($codigo);
            if($invActual==0 || $invActual==null){
                $datos = array($codigo, $cantidad);
                $InvDistribucionOperador->makeInvDistribucion($datos);
            }
            else{
                $nvoInv=$invActual+$cantidad;
                $datos = array($nvoInv, $codigo);
                $InvDistribucionOperador->updateInvDistribucion($datos);
            }
            $ProdDistribucionOperador = new ProductosDistribucionOperaciones();
            $precioActual = $ProdDistribucionOperador->getPrecioProductoDistribucion($codigo);
            if ($precio > $precioActual) {
                $datos = array($precio, $codigo);
                $ProdDistribucionOperador->updatePrecioCompraProductoDistribucion($datos);
            }
        }
        $_SESSION['idCompra'] = $idCompra;
        $_SESSION['tipoCompra'] = $tipoCompra;
        $ruta = "detCompra.php";
        $mensaje = "Detalle de compra adicionado con éxito";
    } catch (Exception $e) {
        $_SESSION['idCompra'] = $idCompra;
        $_SESSION['tipoCompra'] = $tipoCompra;
        $ruta = "detCompra.php";
        $ruta = $rutaError;
        $mensaje = "Error al ingresar el detalle de la factura de compra";
    } finally {
        unset($conexion);
        unset($stmt);
        mover_pag($ruta, $mensaje);
    }
}

function mover_pag($ruta, $Mensaje)
{
    echo '<script >
   alert("' . $Mensaje . '")
   self.location="' . $ruta . '"
   </script>';
}

?>