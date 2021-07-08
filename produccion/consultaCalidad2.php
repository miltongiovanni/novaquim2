<?php
include "../includes/valAcc.php";

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
$calProdOperador = new CalProdOperaciones();
if (!$calProdOperador->isValidLoteCalidad($lote)) {
    $ruta = "buscar_lote2.php";
    $mensaje = "El número de lote no es válido, vuelva a intentar de nuevo";
    $icon = "warning";
    mover_pag($ruta, $mensaje, $icon);
    exit;
} else {
    $_SESSION['lote'] = $lote;
    $ruta = "cal_prod_terminado.php";
    $mensaje = "El número de lote es válido";
    $icon = "success";
    mover_pag($ruta, $mensaje, $icon);
    exit;
}



?>
