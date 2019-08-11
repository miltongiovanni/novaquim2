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
$medidaP = explode(",", $medida);
$idMedida= $medidaP[0];
$producto=$producto." por ".$medidaP[1];
$distribuidor=(round($fabrica*2*1.12,-2))/2;
$detal=(round($fabrica*2*1.4,-2))/2;
$mayor= (round($distribuidor*2*0.93,-2))/2;
$super= (round($fabrica*2*0.93,-2))/2;

$PrecioOperador = new PreciosOperaciones();

if($codGen=$PrecioOperador->codigoGen($codProducto)){
	$cod= ($codGen - $codGen%100)/100;
}
else {
	$codGen=$PrecioOperador->maxCodigoGen($idCodCat);
	$mod=$codGen%100;
	$cod=(($codGen-$mod)/100)+1;
}
$codigo=$cod*100+$idMedida;
$datos = array($codigo, $producto, $fabrica, $distribuidor, $detal, $mayor, $super );

try {
	$lastCodPrecio=$PrecioOperador->makePrecio($datos);
	$ruta = "listarCod.php";
	$mensaje =  "Precio creado correctamente";
	
} catch (Exception $e) {
	$ruta = "crearCod.php";
	$mensaje = "Error al crear el precio";
} finally {
	unset($conexion);
	unset($stmt);
	mover_pag($ruta, $mensaje);
}

function mover_pag($ruta,$Mensaje){
echo'<script language="Javascript">
   alert("'.$Mensaje.'")
   self.location="'.$ruta.'"
   </script>';
}

?>
