<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Lista de Órdenes de Pedido Pendientes por Facturar</title>
<meta charset="utf-8">
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>LISTA DE ÓRDENES DE PEDIDO PENDIENTES POR FACTURAR</strong></div> 
<table width="100%" border="0" summary="encabezado">
  <tr> 
      <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú"></div></td>
  </tr>
</table>
<table border="0" align="center" cellspacing="0" cellpadding="0" summary="cuerpo" width="100%">
<tr>
      <th width="2%" class="formatoEncabezados"></th>
      <th width="4%" class="formatoEncabezados">Pedido</th>
    <th width="23%" class="formatoEncabezados">Cliente</th>
    <th width="9%" class="formatoEncabezados">Fecha Pedido</th>
    <th width="9%" class="formatoEncabezados">Fecha Entrega</th>
    <th width="23%" class="formatoEncabezados">Lugar Entrega</th>
    <th width="18%" class="formatoEncabezados">Dirección Entrega</th>
    <th width="5%" class="formatoEncabezados">Precio</th>
    <th width="7%" class="formatoEncabezados">Estado</th>
  </tr>   
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
$link=conectarServidor();
$sql="	select idPedido, fechaPedido, fechaEntrega, tipo_precio, nomCliente, pedido.Estado, Nom_sucursal, Dir_sucursal from pedido, tip_precio, clientes, clientes_sucursal where Nit_cliente=clientes.nitCliente and clientes_sucursal.Nit_clien=clientes.nitCliente and tipoPrecio=Id_precio and idSucursal=Id_sucursal AND (pedido.Estado='P' or pedido.Estado='L')  order by idPedido";
$result=mysqli_query($link,$sql);
$a=1;
while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
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
	<td class="formatoDatos"><div align="left">'.$row['Nom_sucursal'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Dir_sucursal'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['tipo_precio'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$estado.'</div></td>
	';
	
	echo'</tr>';
	$sqli="select Id_ped, Cod_producto, Nombre as Producto, Can_producto, Prec_producto from det_pedido, prodpre where Id_ped=$pedido and Cod_producto <100000 AND Cod_producto=Cod_prese
	UNION
	select Id_ped, Cod_producto, Producto, Can_producto, Prec_producto from det_pedido, distribucion where Id_ped=$pedido and Cod_producto >=100000 and Cod_producto=Id_distribucion
	union
select Id_ped, Cod_producto, DesServicio as Producto, Can_producto, Prec_producto from det_pedido, servicios, pedido  where Cod_producto=IdServicio and Id_ped=idPedido and Id_ped=$pedido;";
	$resulti=mysqli_query($link,$sqli);
	echo '<tr><td colspan="7"><div class="commenthidden" id="UniqueName'.$a.'"><table width="60%" border="0" align="center" cellspacing="0" summary="detalle">
	<tr>
      <th width="6%" class="formatoEncabezados">Código</th>
	  <th width="50%" class="formatoEncabezados">Producto</th>
      <th width="5%" class="formatoEncabezados">Cantidad</th>
	  <th width="15%" class="formatoEncabezados">Precio Venta</th>
  	</tr>';
	while($rowi=mysqli_fetch_array($resulti, MYSQLI_BOTH))
	{
	echo '<tr>
	<td class="formatoDatos"><div align="center">'.$rowi['Cod_producto'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$rowi['Producto'].'</div></td>
	<td class="formatoDatos"><div align="center"><script  > document.write(commaSplit('.$rowi['Can_producto'].'))</script></div></td>
	<td class="formatoDatos"><div align="center">$ <script  > document.write(commaSplit('.$rowi['Prec_producto'].'))</script></div></td>
	</tr>';
	}
	echo '</table></div></td></tr>';
	$a=$a+1;
}
mysqli_free_result($result);
//mysqli_free_result($resulti);
/* cerrar la conexión */
mysqli_close($link);
?>
</table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú"></div>
</div>
</body>
</html>