<?php
include "includes/valAcc.php";
?>
<?php
include "includes/MedObj.php";
include "includes/calcularDias.php";

foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
$link=conectarServidor();
$qryb="update prodpre set pres_activo=1 where Cod_prese=$IdProdPre;";	
$resultb=mysqli_query($link,$qryb);

if($resultb)
{
	$ruta="listarmed.php";
    mover_pag($ruta,"Presentación Actualizada correctamente");
}
else
{
	$ruta="buscarMed2.php";
	mover_pag($ruta,"Error al Actualizar la Presentación del Producto");
}
mysqli_close($link);//Cerrar la conexion
function mover_pag($ruta,$Mensaje)
{
	echo'<script language="Javascript">
   	alert("'.$Mensaje.'")
   	self.location="'.$ruta.'"
   	</script>';
}
?>
