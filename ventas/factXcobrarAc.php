<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Facturas Vencidas por Cliente</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="scripts/validar.js"></script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>CARTERA VENCIDA POR CLIENTE</strong></div> 
<table width="100%" border="0" summary="encabezado">
  <tr> 
      <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div></td>
  </tr>
</table>
<table border="0" align="center" cellspacing="0" cellpadding="0" summary="cuerpo" width="100%">
<tr>
      <th width="1%" class="formatoEncabezados"></th>
    <th width="23%" class="formatoEncabezados">Cliente</th>
    <th width="8%" class="formatoEncabezados">NIT</th>
    <th width="14%" class="formatoEncabezados">Contacto</th>
    <th width="9%" class="formatoEncabezados">Cargo</th>
    <th width="9%" class="formatoEncabezados">Tel&eacute;fono</th>
    <th width="9%" class="formatoEncabezados">Celular</th>
    <th width="17%" class="formatoEncabezados">Direcci&oacute;n </th>
    <th width="10%" class="formatoEncabezados">Total adeucado</th>
  </tr>   
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;


$fecha_actual=date("Y")."-".date("m")."-".date("d");
$link=conectarServidor();
$sql="	select  Nom_clien, Nit_clien, Contacto, Cargo, Tel_clien, Cel_clien, Dir_clien, sum(Total) as sumtotal, sum(Reten_iva) as sumretiva, sum(Reten_ica) as sumretic, sum(Reten_fte) as sumrfte, sum(IVA) as sumiva
			from factura, clientes WHERE Nit_cliente=Nit_clien and factura.Estado='P' and Factura>00 and Fech_venc<'$fecha_actual' group by Nom_clien order by sumtotal desc;";
$result=mysqli_query($link,$sql);


$a=1;
while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$Nit_clien=$row['Nit_clien'];
	echo'<tr';
	  if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
	  echo '>
	<td class="formatoDatos"><div align="center"><a href="javascript:togglecomments('."'".'UniqueName'.$a."'".')">+/-</a></div></td>
	<td class="formatoDatos"><div align="center">'.$row['Nom_clien'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Nit_clien'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Contacto'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Cargo'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Tel_clien'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Cel_clien'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Dir_clien'].'</div></td>
	<td class="formatoDatos"><div align="center">$ <script  > document.write(commaSplit('.$row['sumtotal'].'))</script></div></td>
	';
	
	echo'</tr>';
	$sqli="select Factura, Fech_fact, Fech_venc, Total, Reten_iva, Reten_ica, Reten_fte, Subtotal, IVA 
			from factura WHERE Nit_cliente='$Nit_clien' and Estado='P' and Fech_venc<'$fecha_actual';";
	$resulti=mysqli_query($link,$sqli);
	
	echo '<tr><td colspan="9"><div class="commenthidden" id="UniqueName'.$a.'"><table width="100%" border="0" align="center" cellspacing="0" summary="detalle">
	<tr>
      <th width="5%" class="formatoEncabezados">Factura</th>
	  <th width="7%" class="formatoEncabezados">F Factura</th>
      <th width="7%" class="formatoEncabezados">F Vencimiento</th>
	  <th width="10%" class="formatoEncabezados">Subtotal</th>
	  <th width="8%" class="formatoEncabezados">Reteiva</th>
	  <th width="8%" class="formatoEncabezados">Reteica</th>
	  <th width="8%" class="formatoEncabezados">Retefuente</th>
	  <th width="10%" class="formatoEncabezados">Iva</th>
	  <th width="10%" class="formatoEncabezados">Total</th>
	  <th width="10%" class="formatoEncabezados">V Cobrar</th>
	  <th width="10%" class="formatoEncabezados">Abonos</th>
	  <th width="10%" class="formatoEncabezados">Saldo</th>
  	</tr>';
	while($rowi=mysqli_fetch_array($resulti, MYSQLI_BOTH))
	{
	$fact=$rowi['Factura'];
	$qryp="select sum(cobro) as Parcial from r_caja where Fact=$fact";
	$resultpago=mysqli_query($link,$qryp);
	$rowpag=mysqli_fetch_array($resultpago);
	if($rowpag['Parcial'])
		$parcial=$rowpag['Parcial'];
	else
		$parcial=0;
	echo '<tr>
	<td class="formatoDatos"><div align="center">'.$rowi['Factura'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$rowi['Fech_fact'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$rowi['Fech_venc'].'</div></td>
	<td class="formatoDatos"><div align="center"><script  > document.write(commaSplit('.$rowi['Subtotal'].'))</script></div></td>
	<td class="formatoDatos"><div align="center">$ <script  > document.write(commaSplit('.$rowi['Reten_iva'].'))</script></div></td>
	<td class="formatoDatos"><div align="center"><script  > document.write(commaSplit('.$rowi['Reten_ica'].'))</script></div></td>
	<td class="formatoDatos"><div align="center">$ <script  > document.write(commaSplit('.$rowi['Reten_fte'].'))</script></div></td>
	<td class="formatoDatos"><div align="center"><script  > document.write(commaSplit('.$rowi['IVA'].'))</script></div></td>
	<td class="formatoDatos"><div align="center">$ <script  > document.write(commaSplit('.$rowi['Total'].'))</script></div></td>
	
	
	<td class="formatoDatos"><div align="center">$ <script  > document.write(commaSplit('.($rowi['Total']-$rowi['Reten_iva']-$rowi['Reten_ica']-$rowi['Reten_fte']).'))</script></div></td>
	<td class="formatoDatos"><div align="center">$ <script  > document.write(commaSplit('.$parcial.'))</script></div></td>
	<td class="formatoDatos"><div align="center">$ <script  > document.write(commaSplit('.($rowi['Total']-$rowi['Reten_iva']-$rowi['Reten_ica']-$rowi['Reten_fte']-$parcial).'))</script></div></td>
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
mysqli_close($link);//Cerrar la conexion
?>
</table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div>
</div>
</body>
</html>