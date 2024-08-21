<?php
include "../../../includes/valAcc.php";
include "../../../includes/calcularDias.php";
// On enregistre notre autoload.
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
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
    <link href="../../../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <title>Ingreso de la compra de<?= $titulo ?></title>
    <meta charset="utf-8">
    <script src="../../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../js/validar.js"></script>
</head>
<body>
<?php
$CompraOperador = new ComprasOperaciones();
$rutaRef = explode("/",$_SERVER['HTTP_REFERER']);
$rutaError= $rutaRef[4];
$idUsuario = $_SESSION['userId'];
//VALIDA QUE LA FACTURA NO HAYA SIDO INGRESADA ANTES
$factExiste = $CompraOperador->checkFactura($idProv, $numFact);
if ($factExiste && count($factExiste) > 0) {
    $idCompra = $factExiste['idCompra'];
    $_SESSION['idCompra'] = $factExiste['idCompra'];
    $_SESSION['tipoCompra'] = $tipoCompra;
    $ruta = "../detalle/";
    $mensaje = "Factura ingresada anteriormente";
    $icon = "error";
    mover_pag($ruta, $mensaje, $icon);
} else {
    $fecha_actual = date("Y") . "-" . date("m") . "-" . date("d");
    $dias_v = Calc_Dias($fechComp, $fecha_actual);
    $dias_f = Calc_Dias($fechVenc, $fechComp);
    if (($dias_v >= -8) && ($dias_v <= 0) && ($dias_f >= 0)) {
        $estadoCompra = 2;
        $datos = array($idProv, $numFact, $fechComp, $fechVenc, $estadoCompra, $tipoCompra, $idUsuario, $descuentoCompra);
        try {
            $idCompra = $CompraOperador->makeCompra($datos);
            $_SESSION['idCompra'] = $idCompra;
            $_SESSION['tipoCompra'] = $tipoCompra;
            $ruta = "../detalle/";
            $mensaje = "Compra creada con éxito";
            $icon = "success";
        } catch (Exception $e) {
            $ruta = $rutaError;
            $mensaje = "Error al ingresar la factura de compra";
            $icon = "error";
        } finally {
            unset($conexion);
            unset($stmt);
            mover_pag($ruta, $mensaje, $icon);
        }

    } else {
        if ($dias_v > 0) {
            $ruta = $rutaError;
            $mensaje = "La fecha de factura de la compra no puede ser de una fecha futura";
            $icon = "error";
            mover_pag($ruta, $mensaje, $icon);
        }
        if ($dias_v < -8) {
            $ruta = $rutaError;
            $mensaje = "La fecha de factura de la compra no puede ser menor de 8 días de la fecha actual";
            $icon = "error";
            mover_pag($ruta, $mensaje, $icon);
        }
        if ($dias_f < 0) {
            $ruta = $rutaError;
            $mensaje = "La fecha de vencimiento de la compra no puede ser menor que la de la fecha de compra";
            $icon = "error";
            mover_pag($ruta, $mensaje, $icon);
        }
    }
}
?>
</body>
</html>