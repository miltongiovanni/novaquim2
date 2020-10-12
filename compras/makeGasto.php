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
$GastoOperador = new GastosOperaciones();

//VALIDA QUE LA FACTURA NO HAYA SIDO INGRESADA ANTES
$factExiste = $GastoOperador->checkFactura($idProv, $numFact);
if ($factExiste && count($factExiste) > 0) {
    $idGasto = $factExiste['idGasto'];
    $_SESSION['idGasto'] = $factExiste['idGasto'];
    mover_pag("detGasto.php", "Factura ingresada anteriormente");
} else {
    $fecha_actual = date("Y") . "-" . date("m") . "-" . date("d");
    $dias_v = Calc_Dias($fechGasto, $fecha_actual);
    $dias_f = Calc_Dias($fechVenc, $fechGasto);
    if (($dias_v >= -8) && ($dias_v <= 0) && ($dias_f >= 0)) {
        $estadoGasto = 2;
        $datos = array($idProv, $numFact, $fechGasto, $fechVenc, $estadoGasto);
        try {
            $idGasto = $GastoOperador->makeGasto($datos);
            $_SESSION['idGasto'] = $idGasto;
            $ruta = "detGasto.php";
            $mensaje = "Gasto creado con éxito";
        } catch (Exception $e) {
            $ruta = $rutaError;
            $mensaje = "Error al ingresar la factura de gasto";
        } finally {
            unset($conexion);
            unset($stmt);
            mover_pag($ruta, $mensaje);
        }

    } else {
        if ($dias_v > 0) {
            mover_pag($rutaError, "La fecha de factura del gasto no puede ser de una fecha futura");
        }
        if ($dias_v < -8) {
            mover_pag($rutaError, "La fecha de factura del gasto no puede ser menor de 8 días de la fecha actual");
        }
        if ($dias_f < 0) {
            mover_pag($rutaError, "La fecha de vencimiento del gasto no puede ser menor que la de la fecha de compra");
        }
    }
}



?>
