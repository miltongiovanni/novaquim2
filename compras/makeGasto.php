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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <title>Ingreso de gastos</title>
    <meta charset="utf-8">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<?php
$GastoOperador = new GastosOperaciones();

//VALIDA QUE LA FACTURA NO HAYA SIDO INGRESADA ANTES
$factExiste = $GastoOperador->checkFactura($idProv, $numFact);
$rutaError = "crearGasto.php";
if ($factExiste && count($factExiste) > 0) {
    $idGasto = $factExiste['idGasto'];
    $_SESSION['idGasto'] = $factExiste['idGasto'];
    $ruta = "detGasto.php";
    $mensaje = "Factura ingresada anteriormente";
    $icon = "error";
    mover_pag($ruta, $mensaje, $icon);
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
            $icon = "success";
        } catch (Exception $e) {
            $ruta = $rutaError;
            $mensaje = "Error al ingresar la factura de gasto";
            $icon = "error";
        } finally {
            unset($conexion);
            unset($stmt);
            mover_pag($ruta, $mensaje, $icon);
        }

    } else {
        if ($dias_v > 0) {
            $ruta = $rutaError;
            $mensaje = "La fecha de factura del gasto no puede ser de una fecha futura";
            $icon = "error";
            mover_pag($ruta, $mensaje, $icon);
        }
        if ($dias_v < -8) {
            $ruta = $rutaError;
            $mensaje = "La fecha de factura del gasto no puede ser menor de 8 días de la fecha actual";
            $icon = "error";
            mover_pag($ruta, $mensaje, $icon);
        }
        if ($dias_f < 0) {
            $ruta = $rutaError;
            $mensaje = "La fecha de vencimiento del gasto no puede ser menor que la de la fecha de compra";
            $icon = "error";
            mover_pag($ruta, $mensaje, $icon);
        }
    }
}
?>
</body>
</html>
