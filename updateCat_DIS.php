<?php
include "includes/valAcc.php";
?>
<?php
include "includes/calcularDias.php";
include "includes/conect.php";
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
$link=conectarServidor();  
$bd="novaquim";
$qry="update cat_dist set Des_cat_dist='$Categoria' where Id_cat_dist=$Cod_cat";
$result=mysqli_query($link,$qry);
if($result)
{
	$perfil1=$_SESSION['Perfil'];
	$ruta="listarcateg_DIS.php";
    mover_pag($ruta,"Categoria de Productos de Distribución Actualizada Correctamente");
}
else
{
	$ruta="buscarCat_DIS.php";
	mover_pag($ruta,"Error al Actualizar la Categoria de Productos de Distribución");
}
mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
function mover_pag($ruta,$Mensaje)
{
	echo'<script language="Javascript">
   	alert("'.$Mensaje.'")
   	self.location="'.$ruta.'"
   	</script>';
}
?>
