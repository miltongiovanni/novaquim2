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
$qry="update cat_clien set Des_cat_cli='$Categoria' where Id_cat_cli=$Cod_cat";
$result=mysqli_query($link,$qry);
if($result)
{
	$perfil1=$_SESSION['Perfil'];
	$ruta="listarCatCli.php";
    mover_pag($ruta,"Categoria de Cliente Actualizada Correctamente");
}
else
{
	$ruta="buscarCatCli.php";
	mover_pag($ruta,"Error al Actualizar la Categoría de Cliente");
}
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
