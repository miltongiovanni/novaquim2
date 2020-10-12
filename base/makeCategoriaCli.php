<?php
include "../includes/valAcc.php";
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
$datos = array($idCatClien, $desCatClien);
$catsCliOperador = new CategoriasCliOperaciones();
try {
    $lastCatClien = $catsCliOperador->makeCatCli($datos);
    $ruta = "listarCatCli.php";
    $mensaje = "Categoría de cliente creada correctamente";

} catch (Exception $e) {
    $ruta = "crearCatCli.php";
    $mensaje = "Error al crear la categoría de cliente";
} finally {
    unset($conexion);
    unset($stmt);
    mover_pag($ruta, $mensaje);
}



?>
