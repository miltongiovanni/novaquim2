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
$datos = array($invEtiq, $codEtiqueta);
$invEtiquetaOperador = new InvEtiquetasOperaciones();

try {
    $invEtiquetaOperador->updateInvEtiqueta($datos);
    $ruta = "../menu.php";
    $mensaje = "Inventario actualizado correctamente";

} catch (Exception $e) {
    $ruta = "a_inv_dist.php";
    $mensaje = "Error al actualizar el inventario";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje, $icon);
}
?>
