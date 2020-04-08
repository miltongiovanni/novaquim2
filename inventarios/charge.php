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
$qry1="select Cod_envase, inv_envase from inv_envase where Cod_envase=(select Env from rel_env_dis where Dist=$cod_dist);";
$result1=mysqli_query($link,$qry1);
$row1=mysqli_fetch_array($result1);
$inv_envase=$row1['inv_envase'];
$qry2="select Cod_tapa, inv_tapa from inv_tapas_val where Cod_tapa=(select Tapa from rel_env_dis where Dist=$cod_dist);";
$result2=mysqli_query($link,$qry2);
$row2=mysqli_fetch_array($result2);
$inv_tapa=$row2['inv_tapa'];
if(($inv_tapa>=$Unidades)&&($inv_envase>=$Unidades))
{
	$qry3="select Id_distribucion, inv_dist from inv_distribucion WHERE Id_distribucion=$cod_dist;";
	$result3=mysqli_query($link,$qry3);
	if($row3=mysqli_fetch_array($result3))
	{
		$inv_dist=$row3['inv_dist'];
		$inv_dist_actual=$inv_dist+$Unidades;
		$qry4="update inv_distribucion set inv_dist=$inv_dist_actual where Id_distribucion=$cod_dist";
		$result4=mysqli_query($link,$qry4);
	}
	else
	{
		$qry5="insert into inv_distribucion (Id_distribucion, inv_dist) values ($cod_dist, $Unidades);";
		$result5=mysqli_query($link,$qry5);
	}
	$inv_tapa_actual=$inv_tapa - $Unidades;
	$inv_envase_actual=$inv_envase - $Unidades;
	$qry6="update inv_envase set inv_envase=$inv_envase_actual where Cod_envase=(select Env from rel_env_dis where Dist=$cod_dist);";
	$result6=mysqli_query($link,$qry6);
	$qry7="update inv_tapas_val set inv_tapa=$inv_tapa_actual where Cod_tapa=(select Tapa from rel_env_dis where Dist=$cod_dist);";
	$result7=mysqli_query($link,$qry7);
	$ruta="menu.php";
	mover_pag($ruta,"Carga de Envase como Producto de Distribución realizado con Éxito");
	mysqli_free_result($result1);
	mysqli_free_result($result2);
	mysqli_free_result($result3);
/* cerrar la conexión */
mysqli_close($link);
}
else
{
	$ruta="cargarEnvase.php";
	mover_pag($ruta,"No hay inventario suficiente de Envases o Tapa");
	mysql_close($link);//Cerrar la conexion
} 
function mover_pag($ruta,$Mensaje)
{
	echo'<script >
	alert("'.$Mensaje.'")
	self.location="'.$ruta.'"
	</script>';
}
?>
