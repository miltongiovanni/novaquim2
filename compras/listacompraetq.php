<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Lista de Compras de Etiquetas</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="scripts/validar.js"></script>
    <script type="text/Javascript">	function togglecomments (postid) {
		var whichpost = document.getElementById(postid);
		if (whichpost.className=="commentshown") { whichpost.className="commenthidden"; } else { whichpost.className="commentshown"; }
	}</script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>LISTADO DE  COMPRAS DE ETIQUETAS</strong></div>
<table width="100%" border="0">
  <tr> 
      <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div></td>
  </tr>
</table>
<table width="79%" border="0" align="center" cellspacing="0" bordercolor="#CCCCCC">
	<tr>
      <th width="2%" class="formatoEncabezados"></th>
      <th width="6%" class="formatoEncabezados">Id Compra</th>
      <th width="9%" class="formatoEncabezados">NIT</th>
      <th width="34%" class="formatoEncabezados">Proveedor</th>
      <th width="7%" class="formatoEncabezados">Factura</th>
      <th width="9%" class="formatoEncabezados">Fecha Compra</th>
      <th width="9%" class="formatoEncabezados">Fecha Vencimiento</th>
      <th width="15%" class="formatoEncabezados">Estado</th>
      <th width="9%" class="formatoEncabezados">Valor Factura </th>
  </tr>   
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  
//parametros iniciales que son los que cambiamos
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
$sql="	SELECT id_compra, nit_prov as NIT, Nom_provee AS Proveedor, Num_fact as Factura, Fech_comp as 'Fecha Compra',
Fech_venc as 'Fecha Vcmto', Des_estado as Estado, total_fact as Total
FROM compras, proveedores, estados
WHERE compras.nit_prov=proveedores.NIT_provee and compra=4 and estado=Id_estado
order BY id_compra DESC;";
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
         	 echo "<a href='listacompraetq.php?pagina=" . $i . "'>" . $i . "</a>&nbsp;"; 
   	} 
}
echo '</div>';

//construyo la sentencia SQL 
$ssql = "SELECT id_compra, nit_prov as NIT, Nom_provee AS Proveedor, Num_fact as Factura, Fech_comp as 'Fecha Compra',
Fech_venc as 'Fecha Vcmto', Des_estado as Estado, total_fact as Total
FROM compras, proveedores, estados
WHERE compras.nit_prov=proveedores.NIT_provee and compra=4 and estado=Id_estado
order BY id_compra DESC limit " . $inicio . "," . $TAMANO_PAGINA;


$rs = mysqli_query($link,$ssql);
$a=1;
while($row=mysqli_fetch_array($rs, MYSQLI_BOTH))
{
	$id_com=$row['id_compra'];
	echo'<tr';
	  if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
	  echo '>
	<td class="formatoDatos"><div align="center"><a aiotitle="click to expand" href="javascript:togglecomments('."'".'UniqueName'.$a."'".')">+/-</a></div></td>
	<td class="formatoDatos"><div align="center">'.$row['id_compra'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['NIT'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Proveedor'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Factura'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Fecha Compra'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Fecha Vcmto'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Estado'].'</div></td>
	<td class="formatoDatos"><div align="right">$ <script > document.write(commaSplit('.$row['Total'].'))</script></div></td>
	';
	
	echo'</tr>';
	$sqli="select Codigo, Nom_etiq as Producto, Cantidad, Precio from det_compras, etiquetas
where Codigo=Cod_etiq and Id_compra=$id_com;";
	$resulti=mysqli_query($link,$sqli);
	echo '<tr><td colspan="7"><div class="commenthidden" id="UniqueName'.$a.'"><table width="70%" border="0" align="center" cellspacing="0" bordercolor="#CCCCCC">
	<tr>
      <th width="6%" class="formatoEncabezados">C&oacute;digo</th>
	  <th width="40%" class="formatoEncabezados">Envase</th>
      <th width="5%" class="formatoEncabezados">Cantidad</th>
	  <th width="12%" class="formatoEncabezados">Precio</th>
  	</tr>';
	while($rowi=mysqli_fetch_array($resulti, MYSQLI_BOTH))
	{
	echo '<tr>
	<td class="formatoDatos"><div align="center">'.$rowi['Codigo'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$rowi['Producto'].'</div></td>
	<td class="formatoDatos"><div align="center"><script > document.write(commaSplit('.$rowi['Cantidad'].'))</script></div></td>
	<td class="formatoDatos"><div align="center">$ <script > document.write(commaSplit('.$rowi['Precio'].'))</script></div></td>
	</tr>';
	}
	echo '</table></div></td></tr>';
	$a=$a+1;
}
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