<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Lista de Facturas de Venta</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="scripts/validar.js"></script>
</head>
<body>
<?php
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  

?>
<div id="contenedor">
<div id="saludo1"><strong>LISTA DE FACTURAS DE VENTA </strong></div> 
<table align="center" width="700" border="0">
  <tr> 
      <form action="Facturas_Xls.php" method="post" target="_blank"><td width="597" align="right"><input name="Submit" type="submit" class="resaltado" value="Exportar a Excel"></td><input name="FchIni" type="hidden" value="<?php echo $FchIni ?>"><input name="FchFin" type="hidden" value="<?php echo $FchFin ?>"></form>
      <td width="93"><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div></td>
  </tr>
</table>
<table border="0" align="center" cellspacing="0">
	<tr>
      <th width="8" class="formatoEncabezados"></th>
      <th width="50" class="formatoEncabezados">Factura</th>
      <th width="49" class="formatoEncabezados">Pedido</th>
      <th width="61" class="formatoEncabezados">Remisi&oacute;n</th>
      <th width="379" class="formatoEncabezados">Cliente</th>
      <th width="113" class="formatoEncabezados">Fecha Factura</th>
      <th width="113" class="formatoEncabezados">Fecha Vencimiento</th>
      <th width="178" class="formatoEncabezados">Vendedor</th>
      <th width="89" class="formatoEncabezados">Total</th>
      <th width="42" class="formatoEncabezados">Estado</th>
  </tr>   
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
$link=conectarServidor();
$sql="	select Factura, Id_pedido, Nit_cliente, Fech_fact, Fech_venc, Id_remision, Ord_compra, Nom_clien, Tel_clien, Dir_clien, 
		Ciudad, nom_personal as vendedor, Total, factura.Estado 
		from factura, clientes, personal,ciudades
		where Nit_cliente=Nit_clien and Cod_vend=Id_personal and Id_ciudad=Ciudad_clien and Fech_fact>='$FchIni' and Fech_fact<='$FchFin' ORDER BY factura desc;";
$result=mysqli_query($link,$sql);
$a=1;
while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$factura=$row['Factura'];
	$Tot=number_format($row['Total'], 0, '.', ',');
	echo'<tr';
	  if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
	  echo '>
	<td class="formatoDatos"><div align="center"><a aiotitle="click to expand" href="javascript:togglecomments('."'".'UniqueName'.$a."'".')">+/-</a></div></td>
	<td class="formatoDatos"><div align="center">'.$row['Factura'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Id_pedido'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Id_remision'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Nom_clien'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Fech_fact'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Fech_venc'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['vendedor'].'</div></td>
	<td class="formatoDatos"><div align="center">$ '.$Tot.'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Estado'].'</div></td>
	';
	
	echo'</tr>';
	$sqli="select Factura, Cod_producto, Can_producto, Nombre as Producto, tasa, prec_producto, Descuento 
	from det_factura, prodpre, tasa_iva, factura 
	where Factura=Id_fact and Factura=$factura and Cod_producto<100000 and Cod_producto=Cod_prese and Cod_iva=Id_tasa 
	UNION 
	select Factura, Cod_producto, Can_producto, Producto, tasa, prec_producto, Descuento 
	from det_factura, distribucion, tasa_iva, factura 
	where Factura=Id_fact and Factura=$factura and Cod_producto>100000 AND Cod_producto=Id_distribucion AND Cod_iva=Id_tasa
	union
select Factura, Cod_producto, Can_producto, DesServicio as Producto, tasa, prec_producto, Descuento 
	from det_factura, servicios, tasa_iva, factura 
	where Factura=Id_fact and Factura=$factura and Cod_producto<100 AND Cod_producto=IdServicio AND Cod_iva=Id_tasa;";
	$resulti=mysqli_query($link,$sqli);
	echo '<tr><td colspan="7"><div class="commenthidden" id="UniqueName'.$a.'"><table width="75%" border="0" align="center" cellspacing="0" bordercolor="#CCCCCC">
	<tr>
      <th width="8%" class="formatoEncabezados">C&oacute;digo</th>
	  <th width="60%" class="formatoEncabezados">Producto</th>
      <th width="6%" class="formatoEncabezados">Cantidad</th>
  	</tr>';
	while($rowi=mysqli_fetch_array($resulti, MYSQLI_BOTH))
	{
	echo '<tr>
	<td class="formatoDatos"><div align="center">'.$rowi['Cod_producto'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$rowi['Producto'].'</div></td>
	<td class="formatoDatos"><div align="center"><script > document.write(commaSplit('.$rowi['Can_producto'].'))</script></div></td>

	</tr>';
	}
	echo '</table></div></td></tr>';
	$a=$a+1;
}
mysqli_close($link);//Cerrar la conexion
?>

</table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div>
</div>
 </body>
</html>