<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Hist&oacute;rico de Pagos</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<script  src="scripts/block.js"></script>
	<script >
	document.onkeypress = stopRKey; 
	</script>
    <script >	function togglecomments (postid) {
		var whichpost = document.getElementById(postid);
		if (whichpost.className=="commentshown") { whichpost.className="commenthidden"; } else { whichpost.className="commentshown"; }
	}</script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>HIST&Oacute;RICO DE PAGOS DE COMPRAS</strong></div>
<table width="1155" border="0" cellspacing="0" cellpadding="0" align="center" summary="encabezado">
  <tr> 
  <td width="961" align="right"><form action="fech_PagosXCompras_Xls.php" method="post"><input name="Submit" type="submit" class="resaltado" value="Exportar a Excel"></form></td>
  <td width="88"><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div></td>
  </tr>
</table>

<table border="0" align="center" cellspacing="0" cellpadding="0" width="99%">
	<tr>
      <th width="3%" class="formatoEncabezados">Id</th>
      <th width="8%" class="formatoEncabezados">Nit</th>
      <th width="25%" class="formatoEncabezados">Proveedor</th>
      <th width="7%" class="formatoEncabezados">Factura</th>
      <th width="12%" class="formatoEncabezados">Total</th>
      <th width="10%" class="formatoEncabezados">Valor Pagado</th>
      <th width="9%" class="formatoEncabezados">Fecha Compra</th>
      <th width="8%" class="formatoEncabezados">Fecha Vto</th>
      <th width="8%" class="formatoEncabezados">Fecha Canc</th>
      <th width="10%" class="formatoEncabezados">Forma de Pago</th>
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
$sql=" select idEgreso as Id, nit_prov as Nit, Nom_provee as Proveedor, numFact as Factura, totalCompra as Total, pago as 'Valor Pagado', fechComp as 'Fecha Compra', fechVenc as 'Fecha Vencimiento', fechPago as 'Fecha Canc', forma_pago as 'Forma de Pago' 
from egreso, compras, proveedores, form_pago 
WHERE egreso.idCompra=compras.idCompra and nit_prov=nitProv and tipoCompra<6 and formPago=Id_fpago
order by Id DESC;";
//llamar funcion de tabla
$result=mysqli_query($link,$sql);
$num_total_registros = mysqli_num_rows($result); 
//calculo el total de páginas 
$total_paginas = ceil($num_total_registros / $TAMANO_PAGINA); 

//muestro los distintos índices de las páginas, si es que hay varias páginas 
echo '<div id="paginas" align="center">';
if ($total_paginas > 1){ 
   	for ($i=1;$i<=$total_paginas;$i++)
	{ 
      	 if ($pagina == $i) 
         	 //si muestro el índice de la página actual, no coloco enlace 
         	 echo $pagina . " "; 
      	 else 
         	 //si el índice no corresponde con la página mostrada actualmente, coloco el enlace para ir a esa página 
         	 echo "<a href='histo_pagos.php?pagina=" . $i . "'>" . $i . "</a>&nbsp;"; 
   	} 
}
echo '</div>';

//construyo la sentencia SQL 
$ssql = "select idEgreso as Id, nit_prov as Nit, Nom_provee as Proveedor, numFact as Factura, totalCompra as Total, pago as 'Valor Pagado', fechComp as 'Fecha Compra', fechVenc as 'Fecha Vencimiento', fechPago as 'Fecha Canc', forma_pago as 'Forma de Pago' 
from egreso, compras, proveedores, form_pago 
WHERE egreso.idCompra=compras.idCompra and nit_prov=nitProv and tipoCompra<6 and formPago=Id_fpago
order by Id DESC limit " . $inicio . "," . $TAMANO_PAGINA;
$rs = mysqli_query($link,$ssql);
$a=1;
while($row=mysqli_fetch_array($rs, MYSQLI_BOTH))
{
	$nit=$row['Nit'];
	echo'<tr';
	if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
	echo '>
	<td class="formatoDatos"><div align="center">'.$row['Id'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Nit'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Proveedor'].'</div></td>	
	<td class="formatoDatos"><div align="center">'.$row['Factura'].'</div></td>
	<td class="formatoDatos"><div align="center">$ '.number_format($row['Total'], 0, '.', ',').'</div></td>
	<td class="formatoDatos"><div align="center">$ '.number_format($row['Valor Pagado'], 0, '.', ',').'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Fecha Compra'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Fecha Vencimiento'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Fecha Canc'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Forma de Pago'].'</div></td>';
	echo'</tr>';
	$a=$a+1;
}

?>
</table>

<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div>
</div>
</body>
</html>