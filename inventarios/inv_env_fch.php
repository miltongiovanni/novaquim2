<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Inventario de Envase en Fecha</title>
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
<div id="saludo1"><strong>INVENTARIO DE ENVASE A <?php echo $Fch; ?></strong></div>
<table width="727" border="0" align="center" summary="encabezado">
  <tr><td width="620" align="right"><form action="Inv_Env_fch_Xls.php" method="post" target="_blank"><input name="Fch" type="hidden" value="<?php echo $Fch ?>">
    <input name="Submit" type="submit" class="resaltado" value="Exportar a Excel"></form></td> 
      <td width="97"><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div></td>
  </tr>
</table>
<table border="0" align="center" cellspacing="0" summary="cuerpo">
<tr>
  <th width="67" class="formatoEncabezados">C&oacute;digo</th>
  <th width="382" class="formatoEncabezados">Envase</th>
  <th width="55" class="formatoEncabezados">Cantidad</th>
  <th width="55" class="formatoEncabezados">Entrada</th>
  <th width="55" class="formatoEncabezados">Salida</th>
  <th width="55" class="formatoEncabezados">Inventario</th>
</tr>   
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
$link=conectarServidor();
$sql="select inv_envase.Cod_envase as Codigo, Nom_envase as Producto, inv_envase as Cantidad from inv_envase, envase
WHERE inv_envase.Cod_envase=envase.Cod_envase;";
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
  <td class="formatoDatos"><div align="center"><script language="javascript" type="text/javascript"> document.write(commaSplit('.$row['Cantidad'].'))</script></div></td>';
  //ENTRADA POR COMPRAS
  $sqle1="select sum(Cantidad) as entrada1 from compras, det_compras where compra=2 and compras.Id_compra=det_compras.Id_compra and Fech_comp>='$Fch' and Codigo=$prod;";

  $resulte1=mysqli_query($link,$sqle1);
  $rowe1=mysqli_fetch_array($resulte1, MYSQLI_BOTH);
  if($rowe1['entrada1']==NULL)
	  $entrada1=0;
  else
	  $entrada1=$rowe1['entrada1'];
  //ENTRADA POR CAMBIO DE PRESENTACI�N
  $sqle2="SELECT sum(Can_prese_nvo) as entrada2 from cambios, det_cambios2, prodpre where det_cambios2.Id_cambio=cambios.Id_cambio and Fech_cambio >='$Fch' and Cod_prese_nvo=Cod_prese and Cod_envase=$prod;";

  $resulte2=mysqli_query($link,$sqle2);
  $rowe2=mysqli_fetch_array($resulte2, MYSQLI_BOTH);
  if($rowe2['entrada2']==NULL)
	  $entrada2=0;
  else
	  $entrada2=$rowe2['entrada2'];
	//ENTRADA POR DESARMADO DE KITS  
  $sqle3="select sum(Cantidad) as entrada3  from desarm_kit, kit where Cod_kit=Id_kit and Fecha_desarm >='$Fch' and Cod_env=$prod;";
  $resulte3=mysqli_query($link,$sqle3);
  $rowe3=mysqli_fetch_array($resulte3, MYSQLI_BOTH);
  if($rowe3['entrada3']==NULL)
	  $entrada3=0;
  else
	  $entrada3=$rowe3['entrada3'];
  $entrada=$entrada1+ $entrada2 + $entrada3;	
  echo '<td class="formatoDatos"><div align="center"><script language="javascript" type="text/javascript"> document.write(commaSplit('.$entrada.'))</script></div></td>';
  
//SALIDA POR ENVASADO
 	$sqls1="SELECT sum(Can_prese) as salida1  from envasado, ord_prod, prodpre where Fch_prod>'$Fch' and envasado.Lote=ord_prod.Lote and Cod_prese=Con_prese and Cod_envase=$prod;";
	$results1=mysqli_query($link,$sqls1);
	$rows1=mysqli_fetch_array($results1, MYSQLI_BOTH);
	if($rows1['salida1']==NULL)
		$salida1=0;
	else
		$salida1=$rows1['salida1'];
	//SALIDA POR ENVASADO DE PRODUCTOS DE DISTRIBUCION
	$sqls2="select sum(Cantidad) as salida2 from det_env_dist, rel_dist_mp where Fch_env_dist>'$Fch' and det_env_dist.Cod_dist=rel_dist_mp.Cod_dist and Cod_envase=$prod;";	
	$results2=mysqli_query($link,$sqls2);
	$rows2=mysqli_fetch_array($results2, MYSQLI_BOTH);
	if($rows2['salida2']==NULL)
		$salida2=0;
	else
		$salida2=$rows2['salida2'];
	//SALIDA POR ARMADO DE KITS
    $sqls3="select sum(Cantidad) as salida3 FROM arm_kit, kit where Cod_kit=kit.Id_kit and Fecha_arm>'$Fch' AND Cod_env=$prod;";	
	$results3=mysqli_query($link,$sqls3);
	$rows3=mysqli_fetch_array($results3, MYSQLI_BOTH);
	if($rows3['salida3']==NULL)
		$salida3=0;
	else
		$salida3=$rows3['salida3'];
	//SALIDA POR VENTA DE JAB�N
	$sqls4="SELECT sum(cantidad) as salida4 from 
	(select sum(Can_producto) as cantidad from remision, det_remision, prodpre 
	where remision.Id_remision=det_remision.Id_remision and Fech_remision>'$Fch' and Cod_producto=Cod_prese and Cod_produc>=504 and Cod_produc<=514 and Cod_envase=$prod
	union
	select sum(Can_producto) as cantidad from remision1, det_remision1, prodpre 
	where remision1.Id_remision=det_remision1.Id_remision and Fech_remision>'$Fch' and Cod_producto=Cod_prese and Cod_produc>=504 and Cod_produc<=514 and Cod_envase=$prod ) as matriz;";	
	$results4=mysqli_query($link,$sqls4);
	$rows4=mysqli_fetch_array($results4, MYSQLI_BOTH);
	if($rows4['salida4']==NULL)
		$salida4=0;
	else
		$salida4=$rows4['salida4'];
	//SALIDA POR REENVASE DE PRODUCTO
	$sqls5="SELECT sum(Can_prese_ant) as salida5 from cambios, det_cambios, prodpre where det_cambios.Id_cambio=cambios.Id_cambio and Fech_cambio >='$Fch' and Cod_prese_ant=Cod_prese and Cod_envase=$prod;";	
	$results5=mysqli_query($link,$sqls5);
	$rows5=mysqli_fetch_array($results5, MYSQLI_BOTH);
	if($rows5['salida5']==NULL)
		$salida5=0;
	else
		$salida5=$rows5['salida5'];
	$salida=$salida1 + $salida2 + $salida3+$salida4+$salida5;
	echo '<td class="formatoDatos"><div align="center"><script language="javascript"  type="text/javascript"> document.write(commaSplit('.$salida.'))</script></div></td>';
  $inv=$row['Cantidad']+$salida-$entrada;
  echo '<td class="formatoDatos"><div align="center"><script language="javascript"  type="text/javascript"> document.write(commaSplit('.$inv.'))</script></div></td>';
  echo '</tr>';
  $a=$a+1;
}
mysqli_free_result($result);
mysqli_free_result($resulte1);
mysqli_free_result($resulte2);
mysqli_free_result($resulte3);

mysqli_free_result($results1);
mysqli_free_result($results2);
mysqli_free_result($results3);
mysqli_free_result($results4);
mysqli_free_result($results5);
mysqli_close($link);//Cerrar la conexion
?>

</table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div>
</div>
</body>
</html>