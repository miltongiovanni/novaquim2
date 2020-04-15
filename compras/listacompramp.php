<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Lista de Compras de Materias Primas</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="scripts/validar.js"></script>
    <script >	function togglecomments (postid) {
		var whichpost = document.getElementById(postid);
		if (whichpost.className=="commentshown") { whichpost.className="commenthidden"; } else { whichpost.className="commentshown"; }
	}</script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>LISTADO DE COMPRAS DE MATERIAS PRIMAS</strong></div>
<table width="100%" border="0">
  <tr> 
      <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;">
      </div></td>
  </tr>
</table>
<table border="0" align="center" cellspacing="0" cellpadding="0" width="95%">
	<tr>
      <th width="1%" class="formatoEncabezados"></th>
      <th width="6%" class="formatoEncabezados">Id Compra</th>
      <th width="9%" class="formatoEncabezados">NIT</th>
      <th width="22%" class="formatoEncabezados">Proveedor</th>
      <th width="6%" class="formatoEncabezados">Factura</th>
      <th width="8%" class="formatoEncabezados">Fech Compra</th>
      <th width="7%" class="formatoEncabezados">Fecha Vto</th>
      <th width="8%" class="formatoEncabezados">Estado</th>
      <th width="8%" class="formatoEncabezados">Valor Factura </th>
      <th width="8%" class="formatoEncabezados">Retefuente </th>
      <th width="9%" class="formatoEncabezados">Rete Ica </th>
      <th width="8%" class="formatoEncabezados">Valor Real </th>
  </tr>  
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;


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
$sql="SELECT id_compra, nit_prov as NIT, Nom_provee AS Proveedor, Num_fact as Factura, Fech_comp,
Fech_venc as 'Fecha Vcmto', Des_estado as Estado, total_fact as Total, retencion, ret_ica
FROM compras, proveedores, estados
WHERE compras.nit_prov=proveedores.nitProv and compra=1 and estado=Id_estado
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
         	 echo "<a href='listacompramp.php?pagina=" . $i . "'>" . $i . "</a>&nbsp;"; 
   	} 
}
echo '</div>';

//construyo la sentencia SQL 
$ssql = "SELECT id_compra, nit_prov as NIT, Nom_provee AS Proveedor, Num_fact as Factura, Fech_comp,
Fech_venc as 'Fecha Vcmto', Des_estado as Estado, total_fact as Total, retencion, ret_ica
FROM compras, proveedores, estados
WHERE compras.nit_prov=proveedores.nitProv and compra=1 and estado=Id_estado
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
	<td class="formatoDatos"><div align="center">'.$row['Fech_comp'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Fecha Vcmto'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Estado'].'</div></td>
	<td class="formatoDatos"><div align="right">$ <script > document.write(commaSplit('.$row['Total'].'))</script></div></td>
	<td class="formatoDatos"><div align="right">$ <script > document.write(commaSplit('.$row['retencion'].'))</script></div></td>
	<td class="formatoDatos"><div align="right">$ <script > document.write(commaSplit('.$row['ret_ica'].'))</script></div></td>
	<td class="formatoDatos"><div align="right">$ <script > document.write(commaSplit('.($row['Total']-$row['retencion']-$row['ret_ica']).'))</script></div></td>
	';
	
	echo'</tr>';
	$sqli="select Id_compra, Codigo, Nom_mprima as Producto, Lote, Cantidad, Precio
	from det_compras, mprimas
	where Codigo=Cod_mprima and Id_compra=$id_com;";
	$resulti=mysqli_query($link,$sqli);
	echo '<tr><td colspan="9"><div class="commenthidden" id="UniqueName'.$a.'"><table width="80%" border="0" align="center" cellspacing="0" bordercolor="#CCCCCC">
	<tr>
      <th width="10%" class="formatoEncabezados">C&oacute;digo</th>
	  <th width="40%" class="formatoEncabezados">Materia Prima</th>
      <th width="15%" class="formatoEncabezados">Lote</th>
      <th width="5%" class="formatoEncabezados">Cantidad</th>
	  <th width="15%" class="formatoEncabezados">Precio</th>
  	</tr>';
	while($rowi=mysqli_fetch_array($resulti, MYSQLI_BOTH))
	{
	echo '<tr>
	<td class="formatoDatos"><div align="center">'.$rowi['Codigo'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$rowi['Producto'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$rowi['Lote'].'</div></td>
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