<?php
include "../includes/valAcc.php";
?>
<?php
include "includes/conect.php";
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
} 
$link=conectarServidor(); 
$qry3="select codPaca, Cantidad FROM rel_dist_emp where Cod_unidad=$cod_unidad";
$result3=mysqli_query($link,$qry3);
$row3=mysqli_fetch_array($result3);
$Cantidad=$row3['Cantidad'];
$pacas=intval($Unidades/$Cantidad);
if($Unidades>=$Cantidad)
{
	$qry2="select invDistribucion from inv_distribucion where codDistribucion=(select codPaca FROM rel_dist_emp where Cod_unidad=$cod_unidad)";
	$result2=mysqli_query($link,$qry2);
	$row2=mysqli_fetch_array($result2);
	$inv_paca=$row2['inv_dist'];
	$qry1="select invDistribucion from inv_distribucion where codDistribucion=$cod_unidad";
	$result1=mysqli_query($link,$qry1);
	$row1=mysqli_fetch_array($result1);
	$inv_unidad=$row1['inv_dist'];
	$inv_actual=$inv_unidad -$pacas*$Cantidad;
	$qry4="update inv_distribucion set invDistribucion=$inv_actual where codDistribucion=$cod_unidad";
	$result4=mysqli_query($link,$qry4);
	$inv_paca_final=$inv_paca+$pacas;
	$qry5="update inv_distribucion set invDistribucion=$inv_paca_final where codDistribucion=(select codPaca FROM rel_dist_emp where Cod_unidad=$cod_unidad)";
	$result5=mysqli_query($link,$qry5);
	$ruta="menu.php";
	mysqli_close($link);
	mover_pag($ruta,"Empaque de Producto realizado con Éxito");
}
else
{
	$ruta="empacar.php";
	mysqli_close($link);//Cerrar la conexion
	mover_pag($ruta,"La paca tiene más unidades de producto");

}
  


?>
