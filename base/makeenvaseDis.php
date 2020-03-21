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
$qry1="select Dist from rel_env_dis where Dist=$cod_dis";
$result1=mysqli_query($link,$qry1);
if($row1=mysqli_fetch_array($result1))
{
	$ruta="envaseDis.php";
	mover_pag($ruta,"Producto incluido con anterioridad");
}
else
{
	$qry2="insert into rel_env_dis (Dist, Env, Tapa) values ($cod_dis, $IdEnvase, $IdTapa)";
	$result2=mysqli_query($link,$qry2);
	$ruta="listarenvaseDis.php";
	mover_pag($ruta,"Relación creada con Éxito");
}
mysqli_free_result($result1);
mysqli_close($link);//Cerrar la conexion
/*
if($inv_paca>=$Unidades)
{
	$qry2="select inv_dist from inv_distribucion where Id_distribucion=(select Cod_unidad FROM rel_dist_emp where Cod_paca=$cod_paca)";
	$result2=mysql_db_query($bd,$qry2);
	$row2=mysql_fetch_array($result2);
	$inv_unidad=$row2['inv_dist'];
	$qry3="select Cod_unidad, Cantidad FROM rel_dist_emp where Cod_paca=$cod_paca";
	$result3=mysql_db_query($bd,$qry3);
	$row3=mysql_fetch_array($result3);
	$Cantidad=$row3['Cantidad'];
	$inv_actual=$inv_unidad + $Cantidad*$Unidades;
	$qry4="update inv_distribucion set inv_dist=$inv_actual where Id_distribucion=(select Cod_unidad FROM rel_dist_emp where Cod_paca=$cod_paca)";
	$result4=mysql_db_query($bd,$qry4);
	$inv_paca_final=$inv_paca-$Unidades;
	$qry5="update inv_distribucion set inv_dist=$inv_paca_final where Id_distribucion=$cod_paca";
	$result5=mysql_db_query($bd,$qry5);
	$ruta="menu.php";
	mover_pag($ruta,"Desempaque de Producto realizado con Éxito");
	mysql_close($link);
}
else
{
	$ruta="desempacar.php";
	mover_pag($ruta,"No hay inventario suficiente de Pacas del producto");
	mysql_close($link);//Cerrar la conexion
}  */
function mover_pag($ruta,$Mensaje){
echo'<script language="Javascript">
   alert("'.$Mensaje.'")
   self.location="'.$ruta.'"
   </script>';
}

?>
