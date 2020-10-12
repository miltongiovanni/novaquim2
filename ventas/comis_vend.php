<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Consulta de Venta de Productos por Referencia</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor">
<?php
foreach ($_POST as $nombre_campo => $valor) {
    ${$nombre_campo} = $valor;
    if(is_array($valor)){
        //echo $nombre_campo.print_r($valor).'<br>';
    }else{
        //echo $nombre_campo. '=' .${$nombre_campo}.'<br>';
    }
} 	
include "includes/utilTabla.php";
include "includes/conect.php" ;
include "includes/calcularDias.php" ; 
$link=conectarServidor();  
$qrybus="select nom_personal from personal where Id_personal=$vendedor;";
$resultbus=mysqli_query($link,$qrybus);
$rowbus=mysqli_fetch_array($resultbus);

?>

<div id="saludo1"><strong>CONSULTA DE COMISIONES DEL VENDEDOR  <?php echo mb_strtoupper($rowbus['nom_personal']); ?></strong></div> 


<table width="100%"  align="center" border="0">
  <tr> 
      <form action="comis_vend_Xls.php" method="post" target="_blank"><td width="91%" align="right"><input name="Submit" type="submit" class="resaltado" value="Exportar a Excel"></td><input name="FchIni" type="hidden" value="<?php echo $FchIni ?>"><input name="FchFin" type="hidden" value="<?php echo $FchFin ?>"><input name="vendedor" type="hidden" value="<?php echo $vendedor ?>"></form>
   <td width="9%"><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú"></div></td>
  </tr>
</table>
<table border="0" align="center" cellspacing="1" width="100%"> 
<tr>
<th width="5%" class="formatoEncabezados">Factura</th>
<th width="29%" class="formatoEncabezados">Cliente</th>
<th width="5%" class="formatoEncabezados">% Desc</th>
<th width="7%" class="formatoEncabezados">Fech Canc</th>
<th width="7%" class="formatoEncabezados">Total</th>
<th width="7%" class="formatoEncabezados">Subtotal</th>
<th width="7%" class="formatoEncabezados">Vtas Nova</th>
<th width="7%" class="formatoEncabezados">Vtas Dist</th>
<th width="9%" class="formatoEncabezados">Com Nova</th>
<th width="8%" class="formatoEncabezados">Com Dist</th>
<th width="9%" class="formatoEncabezados">Com Total</th>
</tr>
<?php
$link=conectarServidor();
$database="novaquim";
//sentencia SQL    tblusuarios.IdUsuario,
$sql="select Factura, nomCliente, Descuento, Total, Subtotal, IVA, fechaCancelacion, sum(empresa) as nova, sum(distribucion) as dis, sum(empresa*com_nova) as com_nova, sum(distribucion*com_dist) as com_dist, (sum(empresa*com_nova)+sum(distribucion*com_dist)) as com_tot from
(select Factura, nomCliente, Descuento, Total, retencionIva, retencionIca, retencionFte, Subtotal, IVA, fechaCancelacion, sum(Can_producto*prec_producto*(1-Descuento)) as empresa, 0 as distribucion, com_dist, com_nova 
from factura, det_factura, clientes, personal where nitCliente=Nit_cliente and codVendedor=$vendedor and fechaCancelacion>='$FchIni' and fechaCancelacion<='$FchFin' and Factura=Id_fact and Cod_producto<100000 AND codVendedor=Id_personal group by Factura
union
select Factura, nomCliente, Descuento, Total, retencionIva, retencionIca, retencionFte, Subtotal, IVA, fechaCancelacion, 0 as empresa, sum(Can_producto*prec_producto*(1-Descuento)) as distribucion, com_dist, com_nova 
from factura, det_factura, clientes, personal where nitCliente=Nit_cliente and codVendedor=$vendedor and fechaCancelacion>='$FchIni' and fechaCancelacion<='$FchFin' and Factura=Id_fact and Cod_producto>100000 AND codVendedor=Id_personal group by Factura) as tabla group by Factura;
";
$result=mysqli_query($link,$sql);
$sum_com_dist=0;
$sum_com_nova=0;
$sum_com_tot=0;
$a=1;
while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$Factura=$row['Factura'];
	$Nom_clien=$row['Nom_clien'];
	$Descuento=$row['Descuento'];
	$Fech_Canc=$row['Fech_Canc'];
	$VlrTotal=number_format($row['Total'], 0, '.', ',');
	$VlrSubtotal=number_format($row['Subtotal'], 0, '.', ',');
	$Vlrnova=number_format($row['nova'], 0, '.', ',');
	$Vlrdis=number_format($row['dis'], 0, '.', ',');
	$Vlrcom_nova=number_format($row['com_nova'], 0, '.', ',');
	$Vlrcom_dist=number_format($row['com_dist'], 0, '.', ',');
	$Vlrcom_tot=number_format($row['com_tot'], 0, '.', ',');
	$sum_com_nova+=$row['com_nova'];
	$sum_com_dist+=$row['com_dist'];
	$sum_com_tot+=$row['com_tot'];
	//$mes=$fecha1[1];
	echo'<tr';
	if (($a++ % 2)==0) echo ' bgcolor="#B4CBEF" ';
	echo '>';
	//echo '<td class="formatoDatos"><div align="center">'.$codigo_ant.'</div></td>';
	echo '<td class="formatoDatos"><div align="center">'.$Factura.'</div></td>';
	echo '<td class="formatoDatos"><div align="left">'.$Nom_clien.'</div></td>';
	echo '<td class="formatoDatos"><div align="center">'.($Descuento*100).' %</div></td>';
	echo '<td class="formatoDatos"><div align="center">'.$Fech_Canc.'</div></td>';
	echo '<td class="formatoDatos"><div align="center">$ '.$VlrTotal.'</div></td>';
	echo '<td class="formatoDatos"><div align="center">$ '.$VlrSubtotal.'</div></td>';
	echo '<td class="formatoDatos"><div align="center">$ '.$Vlrnova.'</div></td>';
	echo '<td class="formatoDatos"><div align="center">$ '.$Vlrdis.'</div></td>';
	echo '<td class="formatoDatos"><div align="center">$ '.$Vlrcom_nova.'</div></td>';
	echo '<td class="formatoDatos"><div align="center">$ '.$Vlrcom_dist.'</div></td>';
	echo '<td class="formatoDatos"><div align="center">$ '.$Vlrcom_tot.'</div></td>';
	echo '</tr>';
}
$Vlrsum_com_nova=number_format($sum_com_nova, 0, '.', ',');
$Vlrsum_com_dist=number_format($sum_com_dist, 0, '.', ',');
$Vlrsum_com_tot=number_format($sum_com_tot, 0, '.', ',');

echo'<tr>
	<td colspan="6" ></Td>
	<td colspan="2" class="titulo" align="right">TOTAL :</Td>
	<td colspan="1" class="titulo"><div align="center">$ '.$Vlrsum_com_nova.'</div> </td>
	<td colspan="1" class="titulo"><div align="center">$ '.$Vlrsum_com_dist.'</div> </td>
	<td colspan="1" class="titulo"><div align="center">$ '.$Vlrsum_com_tot.'</div> </td>
	</tr>';
mysqli_close($link);//Cerrar la conexion
?>

</table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú"></div>
</div>
</body>
</html>