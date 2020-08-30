<?php
include "../includes/valAcc.php";
include "includes/calcularDias.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
<title>Estado de Cuenta por Cliente</title>
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css" >
<script  src="../js/validar.js"></script>

</head>

<body>
<div id="contenedor">
<?php
include "includes/conect.php" ;
foreach ($_POST as $nombre_campo => $valor) 
	{ 
		$asignacion = "\$".$nombre_campo."='".$valor."';"; 
		//echo $nombre_campo." = ".$valor."<br>";  
		eval($asignacion); 
	}  
	$link=conectarServidor();  
	$qrybus="select nomCliente from clientes where nitCliente='$cliente'";
	$resultbus=mysqli_query($link,$qrybus);
	$rowbus=mysqli_fetch_array($resultbus);
?>
<div id="saludo1"><strong>ESTADO DE CUENTA <?php echo strtoupper($rowbus['Nom_clien']); ?></strong></div> 
<form action="EstadoCuenta_Xls.php" method="post" target="_blank"><table width="700" border="0" align="center">
  <tr> <td width="473"><input name="cliente" type="hidden" value="<?php echo $cliente; ?>"></td>
    <td width="127"><input type="submit" name="Submit" value="Exportar a Excel">
    </td>
     <td width="86"><input type="button" onClick="window.location='menu.php'" value="Ir al Menú"></td>
  </tr>
</table></form>
<table border="0" align="center" cellspacing="0" cellpadding="0">
	<tr>
	<th width="18" class="formatoEncabezados"></th>
    <th width="59" align="center" class="formatoEncabezados">Factura</th>
    <th width="128" align="center" class="formatoEncabezados">Fecha Factura</th>
    <th width="128" align="center" class="formatoEncabezados">Fecha Vencimiento</th>
	<th width="120" align="center" class="formatoEncabezados">Total Factura</th>
    <th width="120" align="center" class="formatoEncabezados">Valor a Cobrar</th>
	<th width="120" align="center" class="formatoEncabezados">Saldo Pendiente</th>
	<th width="128" align="center" class="formatoEncabezados">Fecha de Cancelación</th>
    <th width="42" align="center" class="formatoEncabezados">Estado</th>
  </tr>   
<?php
$sql="	select Factura, fechaFactura, fechaVenc, Total, (Total-retencionIva-retencionIca-retencionFte) as 'Valor a Cobrar', (Total-retencionIva-retencionIca-retencionFte-(select SUM(cobro) from r_caja where Fact=Factura group by Fact)) as 'Saldo', fechaCancelacion, Estado 
from factura where Nit_cliente='$cliente' ORDER BY Factura desc;";
$result=mysqli_query($link,$sql);
$a=1;
while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$factura=$row['Factura'];
	if ($row['Estado']=='C')
		$estado='Cancelada';
	if ($row['Estado']=='P')
	  	$estado='Pendiente';
	if ($row['Estado']=='A')
	 	$estado='Anulada';
	if ($row['Saldo']==NULL)
	 		$saldo=$row['Valor a Cobrar'];
	else	$saldo=$row['Saldo'];
		
	if ($row['Fech_Canc']!='0000-00-00')
	 	$cancel=$row['Fech_Canc'];
	else
		$cancel=NULL;
	$Tot=number_format($row['Total'], 0, '.', ',');
	$Valor=number_format($row['Valor a Cobrar'], 0, '.', ',');
	$Saldo=number_format($row['Saldo'], 0, '.', ',');
	echo'<tr';
	  if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
	  echo '>
	<td class="formatoDatos"><div align="center"><a aiotitle="click to expand" href="javascript:togglecomments('."'".'UniqueName'.$a."'".')">+/-</a></div></td>
	<td class="formatoDatos"><div align="center">'.$row['Factura'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Fech_fact'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Fech_venc'].'</div></td>
	<td class="formatoDatos"><div align="right">$ <script > document.write(commaSplit('.$row['Total'].'))</script></div></td>
	<td class="formatoDatos"><div align="right">$ <script > document.write(commaSplit('.$row['Valor a Cobrar'].'))</script></div></td>
	<td class="formatoDatos"><div align="right">$ <script > document.write(commaSplit('.$saldo.'))</script></div></td>
	<td class="formatoDatos"><div align="center">'.$cancel.'</div></td>
	<td class="formatoDatos"><div align="center">'.$estado.'</div></td>
	';
	
	echo'</tr>';
	$sqli="select Id_caja, cobro, Fecha from r_caja where Fact=$factura";
	$resulti=mysqli_query($link,$sqli);
	echo '<tr><td colspan="7"><div class="commenthidden" id="UniqueName'.$a.'"><table border="0" align="center" cellspacing="0" bordercolor="#CCCCCC">
	<tr>
      <th width="40" class="formatoEncabezados">Pago</th>
	  <th width="120" class="formatoEncabezados">Fecha</th>
      <th width="160" class="formatoEncabezados">Valor</th>
  	</tr>';
	while($rowi=mysqli_fetch_array($resulti, MYSQLI_BOTH))
	{
	echo '<tr>
	<td class="formatoDatos"><div align="center">'.$rowi['Id_caja'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$rowi['Fecha'].'</div></td>
	<td class="formatoDatos"><div align="center">$ <script > document.write(commaSplit('.$rowi['cobro'].'))</script></div></td>
	</tr>';
	}
	echo '</table></div></td></tr>';
	$a=$a+1;
}
mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
?>
</table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú"></div>
</div>
</body>
</html>
