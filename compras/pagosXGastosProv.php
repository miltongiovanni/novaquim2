<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Lista de pagos de Facturas de Compras</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
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
	$qrybus="select Nom_provee from proveedores WHERE NIT_provee='$prov'";
	$resultbus=mysqli_query($link,$qrybus);
	$rowbus=mysqli_fetch_array($resultbus);
?>
<div id="saludo1"><strong>LISTADO DE PAGOS DE FACTURAS A FAVOR DE <?php echo strtoupper($rowbus['Nom_provee']); ?>
</strong></div>
<table width="711" border="0" align="center">
  <tr> <form action="PagosXGastosProv_Xls.php" method="post" target="_blank"><input name="prov" type="hidden" value="<?php echo $prov; ?>"><input name="nprov" type="hidden" value="<?php echo $rowbus['Nom_provee']; ?>"><td width="611" align="right"><input name="Submit" type="submit" class="resaltado" value="Exportar a Excel">
    </td></form>
      <td width="90"><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div></td>
  </tr>
</table>

<table border="0" align="center" cellspacing="0" cellpadding="0" width="99%">
	<tr>
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
$link=conectarServidor();
//sentencia SQL    tblusuarios.IdUsuario,
$sql=" SELECT Num_fact as Factura, total_fact as Total, pago as 'Valor Pagado', Fech_comp as 'Fecha Compra', Fech_venc as 'Fecha Vencimiento', Fecha as 'Fecha Canc', forma_pago as 'Forma de Pago' from (select Id_egreso as Id, nit_prov as Nit, Nom_provee as Proveedor, Num_fact, total_fact, pago, Fech_comp, Fech_venc, Fecha, forma_pago  from egreso, gastos, proveedores, form_pago WHERE egreso.Id_compra=gastos.Id_gasto and nit_prov=NIT_provee and tip_compra=6 and form_pago=Id_fpago order by Id DESC) as tabla where Nit='$prov';";
$rs = mysqli_query($link,$sql);
$a=1;
while($row=mysqli_fetch_array($rs, MYSQLI_BOTH))
{
	echo'<tr';
	if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
	echo '>
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