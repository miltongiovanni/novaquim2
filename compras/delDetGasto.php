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

$GastoOperador = new GastosOperaciones();
$DetGastoOperador = new DetGastosOperaciones();

try {
    $datos = array($idGasto, $producto);
    $DetGastoOperador->deleteDetGasto( $datos);
    $GastoOperador->updateTotalesGasto(BASE_C, $idGasto);
    $_SESSION['idGasto'] = $idGasto;
    $ruta = "detGasto.php";
    $mensaje = "Detalle de gasto eliminado con éxito";
} catch (Exception $e) {
    $_SESSION['idGasto'] = $idGasto;
    $ruta = "detGasto.php";
    $mensaje = "Error al eliminar el detalle del gasto";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}



?>
