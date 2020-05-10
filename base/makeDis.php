<?php
include "../includes/valAcc.php";

// On enregistre notre autoload.
function cargarClases($classname)
{
	require '../clases/' . $classname . '.php';
}

spl_autoload_register('cargarClases');

foreach ($_POST as $nombre_campo => $valor) 
{ 
  $asignacion = "\$".$nombre_campo."='".$valor."';"; 
  //echo $nombre_campo." = ".$valor."<br>";  
  eval($asignacion); 
}

$prodActivo=1;
$datos = array($idDistribucion, $producto, $codIva, $idCatDis, $cotiza, $precioVta, $prodActivo, $stockDis, $codSiigo  );
$ProductoDistribucionOperador = new ProductosDistribucionOperaciones();


try {
	$lastCodProductoDistribucion=$ProductoDistribucionOperador->makeProductoDistribucion($datos);
	$ruta = "listarDis.php";
	$mensaje =  "Producto de Distribución creado correctamente";

} catch (Exception $e) {
	$ruta = "crearDis.php";
	$mensaje = "Error al crear el Producto de Distribución";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje);
}



?>
