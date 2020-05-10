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
$qry1="select invDistribucion from inv_distribucion where codDistribucion=$cod_paca";
$result1=mysqli_query($link,$qry1);
$row1=mysqli_fetch_array($result1);
$inv_paca=$row1['inv_dist'];
if($inv_paca>=$Unidades)
{
	$qry2="select invDistribucion from inv_distribucion where codDistribucion=(select codUnidad FROM rel_dist_emp where Cod_paca=$cod_paca)";
	$result2=mysqli_query($link,$qry2);
	$row2=mysqli_fetch_array($result2);
	$inv_unidad=$row2['inv_dist'];
	$qry3="select codUnidad, Cantidad FROM rel_dist_emp where Cod_paca=$cod_paca";
	$result3=mysqli_query($link,$qry3);
	$row3=mysqli_fetch_array($result3);
	$Cantidad=$row3['Cantidad'];
	
	$qry3s="select codUnidad FROM rel_dist_emp where Cod_paca=$cod_paca";
	$result3s=mysqli_query($link,$qry3s);
	$row3s=mysqli_fetch_array($result3s);
	$Cod_unidad=$row3s['Cod_unidad'];
	
	
	$inv_actual=$inv_unidad + $Cantidad*$Unidades;
	$qry4="update inv_distribucion set invDistribucion=$inv_actual where codDistribucion=$Cod_unidad;";
	$result4=mysqli_query($link,$qry4);
	
	/*$fecha_actual=date("Y")."-".date("m")."-".date("d");
	$qryins= "insert into desempaque (Cod_prod_emp, Cod_prod_desemp, Can_empaq, Can_desempaq, Fech_desempaque) values ($cod_paca, $Cod_unidad, $Unidades, $Cantidad, '$fecha_actual')";
	$resultins=mysql_db_query($bd,$qryins);*/
	//AQUI TOCA MIRAR SI NO ESTA CREADO EL ITEM EN EL INVENTARIO
	
	$inv_paca_final=$inv_paca-$Unidades;
	$qry5="update inv_distribucion set invDistribucion=$inv_paca_final where codDistribucion=$cod_paca";
	$result5=mysqli_query($link,$qry5);
	$ruta="menu.php";
	mover_pag($ruta,"Desempaque de Producto realizado con Éxito");
	mysqli_close($link);
}
else
{
	$ruta="desempacar.php";
	mover_pag($ruta,"No hay inventario suficiente de Pacas del producto");
	mysqli_close($link);//Cerrar la conexion
}  

?>