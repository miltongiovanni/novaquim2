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
$DetFormulaOperador = new DetFormulaOperaciones();
$datos = array($idFormula, $codMPrima, $porcentaje/100, $orden);
try {
    $DetFormulaOperador->makeDetFormula($datos);
    $_SESSION['idFormula'] = $idFormula;
    $ruta = "detFormula.php";
    $mensaje = "Detalle de fórmula adicionado con éxito";
} catch (Exception $e) {
    $_SESSION['idFormula'] = $idFormula;
    $ruta = "detFormula.php";
    $ruta = $rutaError;
    $mensaje = "Error al ingresar el detalle de la fórmula";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}



