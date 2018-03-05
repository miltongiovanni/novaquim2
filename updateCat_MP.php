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
$qry="update cat_mp set Des_cat_mp='$Categoria' where Id_cat_mp=$Cod_cat";
$result=mysqli_query($link, $qry);
if($result)
{
	$perfil1=$_SESSION['Perfil'];
	$ruta="listarcateg_MP.php";
    mover_pag($ruta,"Categoria de Materia Prima Actualizada Correctamente");
}
else
{
	$ruta="buscarCat_MP.php";
	mover_pag($ruta,"Error al Actualizar la Categoria de Materia Prima");
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
