<?php
include "includes/valAcc.php";
?>
<?php
include "includes/DisObj.php";
include "includes/calcularDias.php";
foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		//echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	} 
$prodd= new distri();
if($result=$prodd->updateUtilDis($Id_prod, $util_clien, $util_dist))
{
	$ruta="listarDis.php";
    mover_pag($ruta,"Producto de Distribuci�n actualizado correctamente");
}
else
{
	$ruta="buscarDis1.php";
	mover_pag($ruta,"Error al actualizar el Producto de Distribuci�n");
}
function mover_pag($ruta,$Mensaje)
{
	echo'<script language="Javascript">
   	alert("'.$Mensaje.'")
   	self.location="'.$ruta.'"
   	</script>';
}
?>
