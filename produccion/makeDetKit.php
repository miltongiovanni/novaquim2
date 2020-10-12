<?php
include "../includes/valAcc.php";
function cargarClases($classname)
{
    require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');
//ESTOS SON LOS DATOS QUE RECIBE PARA CREAR EL KIT
foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if(is_array($valor)){
        //echo $nombre_campo.print_r($valor).'<br>';
    }else{
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
}
$datos = array($idKit, $codProducto);
$DetKitOperador = new DetKitsOperaciones();
try {
    $DetKitOperador->makeDetKit($datos);
    $_SESSION['idKit'] = $idKit;
    $ruta = "det_kits.php";
    $mensaje = "Detalle de Kit agregado correctamente";

} catch (Exception $e) {

    $ruta = "../menu.php";
    $mensaje = "Error al crear el detalle de kit";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}

