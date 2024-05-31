<?php
include "../../../includes/valAcc.php";
function cargarClases($classname)
{
    require '../../../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
$datos = [];
foreach ($_POST as $nombre_campo => $valor) {
    $datos["{$nombre_campo}"] = $valor;
    ${$nombre_campo} = $valor;
    if(is_array($valor)){
        //echo $nombre_campo.print_r($valor).'<br>';
    }else{
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
foreach ($datos as $key => &$dato){
    if ($dato == ''){
        unset($datos[$key]);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Control de calidad materia prima</title>
    <meta charset="utf-8">
    <link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
    <script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../js/validar.js"></script>
</head>
<body>
<?php

$calMatPrimaOperador = new CalMatPrimaOperaciones();

try {
    $calMatPrimaOperador->updateCalMatPrima($datos);
    $InvMPrimasOperador = new InvMPrimasOperaciones();
    $invActual = $InvMPrimasOperador->getInvMPrimaByLote($datos['cod_mprima'], $datos['lote_mp']);
    if ($invActual == null) {
        $datos_inv_mp = array($datos['cod_mprima'], $datos['lote_mp'], $datos['cantidad'],  $datos['fecha_lote']);
        $InvMPrimasOperador->makeInvMPrima($datos_inv_mp);
    } else {
        $nvoInv = $invActual + $datos['cantidad'];
        $datos_inv_mp = array($nvoInv, $datos['cod_mprima'], $datos['lote_mp']);
        $InvMPrimasOperador->updateInvMPrima($datos_inv_mp);
    }
    $_SESSION['id_cal_mp'] = $datos['id'];
    $ruta = "det_cal_materia_prima.php";
    $mensaje = "Control de Calidad cargado correctamente";
    $icon = "success";
} catch (Exception $e) {
    $ruta = "buscar_lote3.php";
    $mensaje = "Error al ingresar el Control de Calidad";
    $icon = "error";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
</body>
</html>



