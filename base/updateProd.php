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

$datos = array( $nomProducto, $idCatProd , $prodActivo, $densMin , $densMax, $pHmin, $pHmax, $fragancia, $color , $apariencia, $codProducto );
$ProductoOperador = new ProductosOperaciones();

try {
	$ProductoOperador->updateProducto($datos);
	$ruta = "listarProd.php";
	$mensaje =  "Producto actualzado correctamente";
	
} catch (Exception $e) {
	$ruta = "crearProd.php";
	$mensaje = "Error al actualizar el producto";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje);
}

function mover_pag($ruta,$Mensaje)
{
	echo'<script language="Javascript">
   	alert("'.$Mensaje.'")
   	self.location="'.$ruta.'"
   	</script>';
}
?>
