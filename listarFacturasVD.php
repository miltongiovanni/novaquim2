<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Lista de Facturas de Venta</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="scripts/validar.js"></script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>LISTA DE FACTURAS DE VENTA</strong></div> 
<table  align="center" width="700" border="0">
  <tr> 
      <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div></td>
  </tr>
</table>
<table border="0" align="center" cellspacing="0" cellpadding="0">
	<tr>
      <th width="8" class="formatoEncabezados"></th>
      <th width="50" class="formatoEncabezados">Factura</th>
      <th width="49" class="formatoEncabezados">Pedido</th>
      <th width="61" class="formatoEncabezados">Remisi&oacute;n</th>
      <th width="379" class="formatoEncabezados">Cliente</th>
      <th width="113" class="formatoEncabezados">Fecha Factura</th>
      <th width="113" class="formatoEncabezados">Fecha Vencimiento</th>
      <th width="178" class="formatoEncabezados">Directora de Zona</th>
      <th width="89" class="formatoEncabezados">Total</th>
      <th width="42" class="formatoEncabezados">Estado</th>
  </tr>   
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
//parametros iniciales que son los que cambiamos
$servidorBD="localhost";
$usuario="root";
$password="novaquim";
$database="novaquim";
//conectar con el servidor de BD
$link=conectarServidorBD($servidorBD, $usuario, $password);
//conectar con la tabla (ej. use datos;)
conectarBD($database, $link);  
//sentencia SQL    tblusuarios.IdUsuario,
$sql="	select Factura, Id_pedido, Nit_cliente, Fech_fact, Fech_venc, Id_remision, Ord_compra, Nom_clien, Tel_clien, Dir_clien, 
		Ciudad, nom_personal as vendedor, Total, factura.Estado 
		from factura, clientes, personal,ciudades
		where Nit_cliente=Nit_clien and Id_ciudad=Ciudad_clien and Cod_vend=Id_personal and Id_cat_clien=13 ORDER BY factura desc";
$result=mysql_db_query($database,$sql);
$a=1;
while($row=mysql_fetch_array($result, MYSQLI_BOTH))
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
	select Factura, Cod_producto, Can_producto, Producto, tasa, prec_producto, Descuento 
	from det_factura, herramientas, tasa_iva, factura 
	where Factura=Id_fact and Factura=$factura and Cod_producto>=1000000 AND Cod_producto=Id_herramienta AND Cod_iva=Id_tasa order by Producto;";
	$resulti=mysql_db_query($database,$sqli);
	echo '<tr><td colspan="7"><div class="commenthidden" id="UniqueName'.$a.'"><table width="75%" border="0" align="center" cellspacing="0" bordercolor="#CCCCCC">
	<tr>
      <th width="8%" class="formatoEncabezados">C&oacute;digo</th>
	  <th width="60%" class="formatoEncabezados">Producto</th>
      <th width="6%" class="formatoEncabezados">Cantidad</th>
  	</tr>';
	while($rowi=mysql_fetch_array($resulti, MYSQLI_BOTH))
	{
	echo '<tr>
	<td class="formatoDatos"><div align="center">'.$rowi['Cod_producto'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$rowi['Producto'].'</div></td>
	<td class="formatoDatos"><div align="center"><script language="javascript"> document.write(commaSplit('.$rowi['Can_producto'].'))</script></div></td>

	</tr>';
	}
	echo '</table></div></td></tr>';
	$a=$a+1;
}
mysql_close($link);//Cerrar la conexion
?>

</table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div>
</div>
 </body>
</html>