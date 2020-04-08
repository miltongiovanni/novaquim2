<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Inventario de Productos de Distribuci&oacute;n</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="scripts/validar.js"></script>
</head>
<body>
<div id="contenedor">
<?php
foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		//echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	}  
?>
<div id="saludo1"><strong>INVENTARIO DE PRODUCTOS DE DISTRIBUCI&Oacute;N A <?php echo $Fch; ?></strong></div>
<table width="727" border="0" align="center" summary="encabezado">
  <tr><td width="620" align="right"><form action="Inv_Dist_fch_Xls.php" method="post" target="_blank"><input name="Fch" type="hidden" value="<?php echo $Fch ?>">
    <input name="Submit" type="submit" class="resaltado" value="Exportar a Excel"></form></td> 
      <td width="97"><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div></td>
  </tr>
</table>
<table border="0" align="center" cellspacing="0" summary="cuerpo">
<tr>
  <th width="67" class="formatoEncabezados">C&oacute;digo</th>
  <th width="382" class="formatoEncabezados">Producto</th>
  <th width="55" class="formatoEncabezados">Cantidad</th>
  <th width="55" class="formatoEncabezados">Entrada</th>
  <th width="55" class="formatoEncabezados">Salida</th>
  <th width="55" class="formatoEncabezados">Inventario</th>
</tr>   
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
$link=conectarServidor();
//sentencia SQL    tblusuarios.IdUsuario,
$sql="	SELECT inv_distribucion.Id_distribucion as Codigo, Producto, inv_dist as Cantidad from inv_distribucion, distribucion
where inv_distribucion.Id_distribucion=distribucion.Id_distribucion and Activo=0 order by Producto;";
$result=mysqli_query($link,$sql); 
$a=1;
while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
  $prod=$row['Codigo'];
  echo'<tr';
	if (($a++ % 2)==0) echo ' bgcolor="#B4CBEF" ';
	echo '>
  <td class="formatoDatos"><div align="center">'.$row['Codigo'].'</div></td>
  <td class="formatoDatos"><div align="left">'.$row['Producto'].'</div></td>
  <td class="formatoDatos"><div align="center"><script  type="text/javascript"> document.write(commaSplit('.$row['Cantidad'].'))</script></div></td>';
  //ENTRADA POR COMPRAS
  $sqle1="select sum(Cantidad) as entrada1 from compras, det_compras where compras.Id_compra=det_compras.Id_compra and compra=5 and Fech_comp>'$Fch' and Codigo=$prod;";
  $resulte1=mysqli_query($link,$sqle1);
  $rowe1=mysqli_fetch_array($resulte1, MYSQLI_BOTH);
  if($rowe1['entrada1']==NULL)
	  $entrada1=0;
  else
	  $entrada1=$rowe1['entrada1'];
  //ENTRADA POR ARMADO DE KITS
  $sqle2="select sum(Cantidad) as entrada2 FROM arm_kit, kit, distribucion where Cod_kit=Id_kit and Codigo=Id_distribucion and Fecha_arm>='$Fch' and Codigo=$prod;";
  $resulte2=mysqli_query($link,$sqle2);
  $rowe2=mysqli_fetch_array($resulte2, MYSQLI_BOTH);
  if($rowe2['entrada2']==NULL)
	  $entrada2=0;
  else
	  $entrada2=$rowe2['entrada2'];
	//ENTRADA POR DESARMADO DE KITS  
  $sqle3="select sum(Cantidad) as entrada3 FROM desarm_kit, kit, det_kit, distribucion where Cod_kit=det_kit.Id_kit and Cod_producto=Id_distribucion and Fecha_desarm>='$Fch' AND kit.Id_kit=det_kit.Id_kit and Cod_producto=$prod;";
  $resulte3=mysqli_query($link,$sqle3);
  $rowe3=mysqli_fetch_array($resulte3, MYSQLI_BOTH);
  if($rowe3['entrada3']==NULL)
	  $entrada3=0;
  else
	  $entrada3=$rowe3['entrada3'];
  //ENTRADA POR ENVASADO
  $sqle4="select sum(Cantidad) as entrada4 from env_dist, rel_dist_mp, det_env_dist where env_dist.Id_env_dist=Cod_MP and rel_dist_mp.Cod_dist=det_env_dist.Cod_dist and Fch_env_dist>='$Fch' and det_env_dist.Cod_dist=$prod;";
  $resulte4=mysqli_query($link,$sqle4);
  $rowe4=mysqli_fetch_array($resulte4, MYSQLI_BOTH);
  if($rowe4['entrada4']==NULL)
	  $entrada4=0;
  else
	  $entrada4=$rowe4['entrada4'];
  $entrada=$entrada1 + $entrada2 + $entrada3 + $entrada4;	
  echo '<td class="formatoDatos"><div align="center"><script  type="text/javascript"> document.write(commaSplit('.$entrada.'))</script></div></td>';
  
    //SALIDA POR VENTAS
  $sqls1="select sum(Can_producto) as salida1 from det_remision, remision where remision.Id_remision=det_remision.Id_remision and Fech_remision>='$Fch' and Cod_producto=$prod;";
	$results1=mysqli_query($link,$sqls1);
	$rows1=mysqli_fetch_array($results1, MYSQLI_BOTH);
	if($rows1['salida1']==NULL)
		$salida1=0;
	else
		$salida1=$rows1['salida1'];
	//SALIDA POR REMISION
	$sqls2="select sum(Can_producto) as salida2 from det_remision1, remision1 where remision1.Id_remision=det_remision1.Id_remision and Fech_remision>='$Fch' and Cod_producto=$prod;";	
	$results2=mysqli_query($link,$sqls2);
	$rows2=mysqli_fetch_array($results2, MYSQLI_BOTH);
	if($rows2['salida2']==NULL)
		$salida2=0;
	else
		$salida2=$rows2['salida2'];
	//SALIDA POR DESARMADO DE KITS
	$sqls4="select sum(Cantidad) as salida4 FROM desarm_kit, kit, distribucion where Cod_kit=Id_kit and Codigo=Id_distribucion and Fecha_desarm>='$Fch' and Codigo=$prod;";	
	$results4=mysqli_query($link,$sqls4);
	$rows4=mysqli_fetch_array($results4, MYSQLI_BOTH);
	if($rows4['salida4']==NULL)
		$salida4=0;
	else
		$salida4=$rows4['salida4'];
	//SALIDA POR ARMADO DE KITS
    $sqls3="select sum(Cantidad) as salida3 FROM arm_kit, kit, det_kit, distribucion where Cod_kit=det_kit.Id_kit and Cod_producto=Id_distribucion and Fecha_arm>='$Fch' AND kit.Id_kit=det_kit.Id_kit and Cod_producto=$prod";	
	$results3=mysqli_query($link,$sqls3);
	$rows3=mysqli_fetch_array($results3, MYSQLI_BOTH);
	if($rows3['salida3']==NULL)
		$salida3=0;
	else
		$salida3=$rows3['salida3'];
	$salida=$salida1 + $salida2 + $salida3 + $salida4;
	echo '<td class="formatoDatos"><div align="center"><script   type="text/javascript"> document.write(commaSplit('.$salida.'))</script></div></td>';
  $inv=$row['Cantidad']+$salida-$entrada;
  echo '<td class="formatoDatos"><div align="center"><script   type="text/javascript"> document.write(commaSplit('.$inv.'))</script></div></td>';
  echo '</tr>';
  $a=$a+1;
}
mysqli_free_result($result);
mysqli_free_result($resulte1);
mysqli_free_result($resulte2);
mysqli_free_result($resulte3);
mysqli_free_result($resulte4);
mysqli_free_result($results1);
mysqli_free_result($results2);
mysqli_free_result($results3);
mysqli_free_result($results4);
mysqli_close($link);//Cerrar la conexion
?>

</table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div>
</div>
</body>
</html>