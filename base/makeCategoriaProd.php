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
$datos = array($idCatProd, $catProd);
$catsProdOperador = new CategoriasProdOperaciones();

try {
	$lastCatProd=$catsProdOperador->makeCatProd($datos);
	$ruta = "listarCatProd.php";
	$mensaje =  "Categoría de producto creada correctamente";
	
} catch (Exception $e) {
	$ruta = "crearCategoriaProd.php";
	$mensaje = "Error al crear la categoría de producto";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje);
}



?>
