<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Lista de &Oacute;rdenes de Pedido</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="scripts/validar.js"></script>
</head>
<body>
<div id="contenedor">
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
if($_GET)
{
		$IdPersonal = $_GET["Personal"];
}
	
if($_POST)
{
	foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		//echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	}
}

//parametros iniciales que son los que cambiamos
$link=conectarServidor();
$sqlv="	select nom_personal from Personal where Id_personal=$IdPersonal;";
$resultv=mysqli_query($link,$sqlv);
$rowv=mysqli_fetch_array($resultv, MYSQLI_BOTH);
$vendedor=$rowv['nom_personal'];

 
?>
<div id="saludo1"><strong>LISTA DE &Oacute;RDENES DE PEDIDO DE <?php echo strtoupper($vendedor); ?></strong></div> 
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
    <th width="23%" class="formatoEncabezados">Lugar Entrega</th>
    <th width="18%" class="formatoEncabezados">Direcci&oacute;n Entrega</th>
    <th width="5%" class="formatoEncabezados">Precio</th>
    <th width="7%" class="formatoEncabezados">Estado</th>
  </tr>   


<?php
//Limito la busqueda 
$TAMANO_PAGINA = 20; 

//examino la página a mostrar y el inicio del registro a mostrar 
if(isset($_GET['pagina'])) 
{
    $pagina = $_GET['pagina']; 
}
else
	$pagina=NULL;
	
if (!$pagina) 
{ 
   	 $inicio = 0; 
   	 $pagina=1; 
} 
else 
{ 
   	$inicio = ($pagina - 1) * $TAMANO_PAGINA; 
}

$link=conectarServidor();
$sql="	select Id_pedido, Fech_pedido, Fech_entrega, tipo_precio, Nom_clien, pedido.Estado, Nom_sucursal, Dir_sucursal 
from pedido, tip_precio, clientes, clientes_sucursal 
where Nit_cliente=clientes.Nit_clien and clientes_sucursal.Nit_clien=clientes.Nit_clien and  tip_precio=Id_precio and Id_sucurs=Id_sucursal and Cod_vend=$IdPersonal order by Id_pedido DESC;";
$result=mysqli_query($link,$sql);

$num_total_registros = mysqli_num_rows($result); 
//calculo el total de páginas 
$total_paginas = ceil($num_total_registros / $TAMANO_PAGINA); 

//muestro los distintos índices de las páginas, si es que hay varias páginas 
echo '<div id="paginas" align="center">';
if ($total_paginas > 1){ 
   	for ($i=1;$i<=$total_paginas;$i++){ 
      	 if ($pagina == $i) 
         	 //si muestro el índice de la página actual, no coloco enlace 
         	 echo $pagina . " "; 
      	 else 
         	 //si el índice no corresponde con la página mostrada actualmente, coloco el enlace para ir a esa página 
         	 echo "<a href='listarPedidoVend.php?pagina=" . $i . "&Personal=" . $IdPersonal . "'>" . $i . "</a>&nbsp;"; 
   	} 
}
echo '</div>';


//construyo la sentencia SQL 
$ssql = "select Id_pedido, Fech_pedido, Fech_entrega, tipo_precio, Nom_clien, pedido.Estado, Nom_sucursal, Dir_sucursal 
from pedido, tip_precio, clientes, clientes_sucursal 
where Nit_cliente=clientes.Nit_clien and clientes_sucursal.Nit_clien=clientes.Nit_clien and  tip_precio=Id_precio and Id_sucurs=Id_sucursal and Cod_vend=$IdPersonal order by Id_pedido DESC limit " . $inicio . "," . $TAMANO_PAGINA; 
$rs = mysqli_query($link,$ssql);
$a=1;
while($row=mysqli_fetch_array($rs, MYSQLI_BOTH))
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
	<td class="formatoDatos"><div align="center">'.$estado.'</div></td>';
	
	echo'</tr>';
	$sqli="select Id_ped, Cod_producto, Nombre as Producto, Can_producto, Prec_producto from det_pedido, prodpre where Id_ped=$pedido and Cod_producto <100000 AND Cod_producto=Cod_prese
	UNION
	select Id_ped, Cod_producto, Producto, Can_producto, Prec_producto from det_pedido, distribucion where Id_ped=$pedido and Cod_producto >=100000 and Cod_producto=Id_distribucion
	union
select Id_ped, Cod_producto, DesServicio as Producto, Can_producto, Prec_producto from det_pedido, servicios, pedido  where Cod_producto=IdServicio and Id_ped=Id_pedido and Id_ped=$pedido;";
	$resulti=mysqli_query($link,$sqli);
	echo '<tr><td colspan="7"><div class="commenthidden" id="UniqueName'.$a.'"><table width="60%" border="0" align="center" cellspacing="0" summary="detalle">
	<tr>
      <th width="6%" class="formatoEncabezados">C&oacute;digo</th>
	  <th width="50%" class="formatoEncabezados">Producto</th>
      <th width="5%" class="formatoEncabezados">Cantidad</th>
	  <th width="15%" class="formatoEncabezados">Precio Venta</th>
  	</tr>';
	while($rowi=mysqli_fetch_array($resulti, MYSQLI_BOTH))
	{
	echo '<tr>
	<td class="formatoDatos"><div align="center">'.$rowi['Cod_producto'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$rowi['Producto'].'</div></td>
	<td class="formatoDatos"><div align="center"><script language="javascript" type="text/javascript"> document.write(commaSplit('.$rowi['Can_producto'].'))</script></div></td>
	<td class="formatoDatos"><div align="center">$ <script language="javascript" type="text/javascript"> document.write(commaSplit('.$rowi['Prec_producto'].'))</script></div></td>
	</tr>';
	}
	echo '</table></div></td></tr>';
	$a=$a+1;
}
//pongo el número de registros total, el tamaño de página y la página que se muestra 
/*echo "Número de registros encontrados: " . $num_total_registros . "<br>"; 
echo "Se muestran páginas de " . $TAMANO_PAGINA . " registros cada una<br>"; 
echo "Mostrando la página " . $pagina . " de " . $total_paginas . "<p>"; */
mysqli_free_result($result);
mysqli_free_result($resulti);
/* cerrar la conexión */
mysqli_close($link);
?>
</table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div>
</div>
</body>
</html>