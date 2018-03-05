<?php
include "includes/valAcc.php";
?>
<?php
include "includes/conect.php";
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
$link=conectarServidor();  
$qry="update cat_prov set Des_cat_prov='$Categoria' where Id_cat_prov=$Cod_cat";
$result=mysqli_query($link,$qry);
if($result)
{
	$perfil1=$_SESSION['Perfil'];
	$ruta="listarCatProv.php";
    mover_pag($ruta,"Categoria de Proveedor Actualizada Correctamente");
}
else
{
	$ruta="buscarCatProv.php";
	mover_pag($ruta,"Error al Actualizar Categoría de Proveedor");
}	
mysqli_close($link);

function mover_pag($ruta,$Mensaje)
{
	echo'<script language="Javascript">
   	alert("'.$Mensaje.'")
   	self.location="'.$ruta.'"
   	</script>';
}
?>
