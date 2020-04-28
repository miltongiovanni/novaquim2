<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Lista de Gastos de Novaquim</title>
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
<div id="saludo1"><strong>LISTA DE GASTOS DE INDUSTRIAS NOVAQUIM</strong></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
      <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;">
      </div></td>
  </tr>
</table>
<table width="79%" border="0" align="center" cellspacing="0" cellpadding="0" bordercolor="#CCCCCC">
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
$sql="	SELECT Id_gasto, nit_prov, Num_fact, Fech_comp, Fech_venc, descEstado as Estado, total_fact, Nom_provee 
from gastos, proveedores, estados WHERE nit_prov=nitProv and estado=idEstado
order BY Fech_comp desc;";
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
         	 echo "<a href='listagastos.php?pagina=" . $i . "'>" . $i . "</a>&nbsp;"; 
   	} 
}
echo '</div>';

//construyo la sentencia SQL 
$ssql = "SELECT Id_gasto, nit_prov, Num_fact, Fech_comp, Fech_venc, descEstado as Estado, total_fact, Nom_provee 
from gastos, proveedores, estados WHERE nit_prov=nitProv and estado=idEstado
order BY Fech_comp desc limit " . $inicio . "," . $TAMANO_PAGINA;


$rs = mysqli_query($link,$ssql);
$a=1;
while($row=mysqli_fetch_array($rs, MYSQLI_BOTH))
{
	$id_com=$row['Id_gasto'];
	echo'<tr';
	  if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
	  echo '>
	<td class="formatoDatos"><div align="center"><a aiotitle="click to expand" href="javascript:togglecomments('."'".'UniqueName'.$a."'".')">+/-</a></div></td>
	<td class="formatoDatos"><div align="center">'.$row['Id_gasto'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['nit_prov'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Nom_provee'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Num_fact'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Fech_comp'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Fech_venc'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Estado'].'</div></td>
	<td class="formatoDatos"><div align="right">$ <script > document.write(commaSplit('.$row['total_fact'].'))</script></div></td>
	';
	
	echo'</tr>';
	$sqli="select Producto, Cant_gasto, Precio_gasto, tasa from det_gastos, tasa_iva 
where det_gastos.Id_tasa=tasa_iva.Id_Tasa and Id_gasto=$id_com;";
	$resulti=mysqli_query($link,$sqli);
	echo '<tr><td colspan="7"><div class="commenthidden" id="UniqueName'.$a.'"><table width="65%" border="0" align="center" cellspacing="0" bordercolor="#CCCCCC">
	<tr>
	  <th width="49%" class="formatoEncabezados">Descripción</th>
      <th width="10%" class="formatoEncabezados">Cantidad</th>
	  <th width="20%" class="formatoEncabezados">Precio</th> 
	  <th width="10%" class="formatoEncabezados">Iva</th>
  	</tr>';
	while($rowi=mysqli_fetch_array($resulti, MYSQLI_BOTH))
	{
	echo '<tr>
	<td class="formatoDatos"><div align="center">'.$rowi['Producto'].'</div></td>
	<td class="formatoDatos"><div align="center"><script > document.write(commaSplit('.$rowi['Cant_gasto'].'))</script></div></td>
	<td class="formatoDatos"><div align="center">$ <script > document.write(commaSplit('.$rowi['Precio_gasto'].'))</script></div></td>
	<td class="formatoDatos"><div align="center"><script > document.write(commaSplit('.(100*$rowi['tasa']).'))</script> %</div></td>
	</tr>';
	}
	echo '</table></div></td></tr>';
	$a=$a+1;
}
mysqli_free_result($result);
mysqli_free_result($resulti);
mysqli_close($link);//Cerrar la conexion
?>

</table>
<table width="27%" border="0" align="center">
    <tr><td><div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div></td></tr>
</table>
</div>
</body>
</html>