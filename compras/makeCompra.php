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
    ${$nombre_campo} = $valor;
    if(is_array($valor)){
        //echo $nombre_campo.print_r($valor).'<br>';
    }else{
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
$CompraOperador = new ComprasOperaciones();

//VALIDA QUE LA FACTURA NO HAYA SIDO INGRESADA ANTES
$factExiste = $CompraOperador->checkFactura($idProv, $numFact);
if ($factExiste && count($factExiste) > 0) {
    $idCompra = $factExiste['idCompra'];
    $_SESSION['idCompra'] = $factExiste['idCompra'];
    $_SESSION['tipoCompra'] = $tipoCompra;
    mover_pag("detCompra.php", "Factura ingresada anteriormente");
} else {
    $fecha_actual = date("Y") . "-" . date("m") . "-" . date("d");
    $dias_v = Calc_Dias($fechComp, $fecha_actual);
    $dias_f = Calc_Dias($fechVenc, $fechComp);
    if (($dias_v >= -8) && ($dias_v <= 0) && ($dias_f >= 0)) {
        $estadoCompra = 2;
        $datos = array($idProv, $numFact, $fechComp, $fechVenc, $estadoCompra, $tipoCompra);
        try {
            $idCompra = $CompraOperador->makeCompra($datos);
            $_SESSION['idCompra'] = $idCompra;
            $_SESSION['tipoCompra'] = $tipoCompra;
            $ruta = "detCompra.php";
            $mensaje = "Compra creada con éxito";
        } catch (Exception $e) {
            $ruta = $rutaError;
            $mensaje = "Error al ingresar la factura de compra";
        } finally {
            unset($conexion);
            unset($stmt);
            mover_pag($ruta, $mensaje, $icon);
        }

    } else {
        if ($dias_v > 0) {
            mover_pag($rutaError, "La fecha de factura de la compra no puede ser de una fecha futura");
        }
        if ($dias_v < -8) {
            mover_pag($rutaError, "La fecha de factura de la compra no puede ser menor de 8 días de la fecha actual");
        }
        if ($dias_f < 0) {
            mover_pag($rutaError, "La fecha de vencimiento de la compra no puede ser menor que la de la fecha de compra");
        }
    }
}



?>
