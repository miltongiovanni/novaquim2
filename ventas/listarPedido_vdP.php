<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Lista de &Oacute;rdenes de Pedido Pendientes por Facturar</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="scripts/validar.js"></script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>LISTA DE &Oacute;RDENES DE PEDIDO DE VENTA DIRECTA PENDIENTES POR FACTURAR</strong></div> 
<table width="100%" border="0" summary="encabezado">
  <tr> 
      <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div></td>
  </tr>
</table>
<table border="0" align="center" cellspacing="0" cellpadding="0" summary="cuerpo" width="100%">
<tr>
      <th width="2%" class="formatoEncabezados"></th>
      <th width="4%" class="formatoEncabezados">Pedido</th>
    <th width="23%" class="formatoEncabezados">Cliente</th>
    <th width="9%" class="formatoEncabezados">Fecha Pedido</th>
    <th width="9%" class="formatoEncabezados">Fecha Entrega</th>
    <th width="18%" class="formatoEncabezados">Direcci&oacute;n Entrega</th>
    <th width="23%" class="formatoEncabezados">Directora de Zona</th>
    <th width="7%" class="formatoEncabezados">Estado</th>
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
$sql="	select Id_pedido, Fech_pedido, Fech_entrega, tipo_precio, Nom_clien, pedido.Estado, Nom_sucursal, Dir_sucursal, nom_personal from pedido, tip_precio, clientes, clientes_sucursal, personal 
where Nit_cliente=clientes.Nit_clien and clientes_sucursal.Nit_clien=clientes.Nit_clien and tip_precio=Id_precio and Id_sucurs=Id_sucursal and Id_cat_clien=13 and cod_vend=Id_personal  AND (pedido.Estado='P' or pedido.Estado='L') order by Id_pedido DESC;";
$result=mysql_db_query($database,$sql);
$a=1;
while($row=mysql_fetch_array($result, MYSQLI_BOTH))
{
	$pedido=$row['Id_pedido'];
	if ($row['Estado']=='A')
	  	$estado='Anulado';
		if ($row['Estado']=='F')
	  	$estado='Facturado';
		if ($row['Estado']=='P')
	  	$estado='Pendiente';
		if ($row['Estado']=='L')
	  	$estado='Por Facturar';
	echo'<tr';
	  if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
	  echo '>
	<td class="formatoDatos"><div align="center"><a href="javascript:togglecomments('."'".'UniqueName'.$a."'".')">+/-</a></div></td>
	<td class="formatoDatos"><div align="center">'.$row['Id_pedido'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Nom_clien'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Fech_pedido'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Fech_entrega'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Dir_sucursal'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['nom_personal'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$estado.'</div></td>
	';
	
	echo'</tr>';
	$sqli="select Id_ped, Cod_producto, Nombre as Producto, Can_producto from det_pedido, prodpre where Id_ped=$pedido and Cod_producto <100000 AND Cod_producto=Cod_prese
	UNION
	select Id_ped, Cod_producto, Producto, Can_producto from det_pedido, distribucion where Id_ped=$pedido and Cod_producto >=100000 and Cod_producto=Id_distribucion
	UNION
	select Id_ped, Cod_producto, Producto, Can_producto from det_pedido, herramientas where Id_ped=$pedido and Cod_producto>1000000 and Cod_producto=Id_herramienta;";
	$resulti=mysql_db_query($database,$sqli);
	echo '<tr><td colspan="7"><div class="commenthidden" id="UniqueName'.$a.'"><table width="60%" border="0" align="center" cellspacing="0" summary="detalle">
	<tr>
      <th width="6%" class="formatoEncabezados">C&oacute;digo</th>
	  <th width="50%" class="formatoEncabezados">Producto</th>
      <th width="5%" class="formatoEncabezados">Cantidad</th>
  	</tr>';
	while($rowi=mysql_fetch_array($resulti, MYSQLI_BOTH))
	{
	echo '<tr>
	<td class="formatoDatos"><div align="center">'.$rowi['Cod_producto'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$rowi['Producto'].'</div></td>
	<td class="formatoDatos"><div align="center"><script  type="text/javascript"> document.write(commaSplit('.$rowi['Can_producto'].'))</script></div></td>

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