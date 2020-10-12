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
$FormulaMPrimaOperador = new FormulasMPrimaOperaciones();
$datos = array($codMPrima);
try {
    $idFormulaMPrima=$FormulaMPrimaOperador->makeFormulaMPrima($datos);
    $_SESSION['idFormulaMPrima'] = $idFormulaMPrima;
    $ruta = "detFormulaMPrima.php";
    $mensaje = "Fórmula de materia prima creada con éxito";
} catch (Exception $e) {
    $ruta = "formula_MP.php";
    $mensaje = "Error al crear la fórmula de materia prima";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}



