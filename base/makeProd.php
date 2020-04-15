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
$datos = array($codProducto, $nomProducto, $idCatProd , $prodActivo, $densMin , $densMax, $pHmin, $pHmax, $fragancia, $color , $apariencia );
$ProductoOperador = new ProductosOperaciones();


try {
	$lastCodProducto=$ProductoOperador->makeProducto($datos);
	$ruta = "listarProd.php";
	$mensaje =  "Producto creado correctamente";
	
} catch (Exception $e) {
	$ruta = "crearProd.php";
	$mensaje = "Error al crear el producto";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje);
}
	
function mover_pag($ruta,$Mensaje){
echo'<script >
   alert("'.$Mensaje.'")
   self.location="'.$ruta.'"
   </script>';
}

?>
