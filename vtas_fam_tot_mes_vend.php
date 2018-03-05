<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Consulta de Venta de Productos por Referencia</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="scripts/validar.js"></script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>CONSULTA DE VENTAS POR FAMILIA DE PRODUCTOS POR MES</strong></div> 

<?php
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  

?>
<table width="100%"  align="center" border="0">
  <tr> 
      <form action="vtas_fam_tot_mes_vend_Xls.php" method="post" target="_blank"><td width="91%" align="right"><input name="Submit" type="submit" class="resaltado" value="Exportar a Excel"></td><input name="FchIni" type="hidden" value="<?php echo $FchIni ?>"><input name="FchFin" type="hidden" value="<?php echo $FchFin ?>"><input name="vendedor" type="hidden" value="<?php echo $vendedor ?>"></form>
      <td width="9%"><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div></td>
  </tr>
</table>
<table border="0" align="center" cellspacing="0"> 
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
include "includes/calcularDias.php" ;
$fecha2=explode('-', $FchFin);
$fecha1=explode('-', $FchIni);
$mes1=$fecha1[1];
$mes2=$fecha2[1];
echo '<tr>';
//echo '<th class="formatoEncabezados" rowspan="2">C&oacute;digo</th>';
echo '<th class="formatoEncabezados" rowspan="2">Producto</th>';

for ($m=$mes1; $m<=$mes2; $m++)
{
echo '<th class="formatoEncabezados" colspan="2">Venta Mes '.$m.'</th>';

}
echo '</tr><tr>';
for ($n=$mes1; $n<=$mes2; $n++)
{
echo '<th class="formatoEncabezados">Un </th><th class="formatoEncabezados">Total</th>';

}
echo '</tr>';
//$meses=$mes2-$mes1;
//echo "Mes inicial ".$fecha1[1];
//echo "Mes final ".$fecha2[1];
//echo "Estos son los meses ".$meses;
//parametros iniciales que son los que cambiamos
$link=conectarServidor();
//sentencia SQL    tblusuarios.IdUsuario,
$sql="select codigo_ant, producto from precios where pres_activa=0 order by producto;";
$result=mysqli_query($link,$sql);
$a=1;
while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$codigo_ant=$row['codigo_ant'];
	$producto=$row['producto'];
	//$PrComp=number_format($row['precio_com'], 0, '.', ',');
	//$PrVta=number_format($row['prec_venta'], 0, '.', ',');
	$mes=$fecha1[1];
	 echo'<tr';
	if (($a++ % 2)==0) echo ' bgcolor="#B4CBEF" ';
	echo '>';
	//echo '<td class="formatoDatos"><div align="center">'.$codigo_ant.'</div></td>';
	echo '<td class="formatoDatos"><div align="left">'.$producto.'</div></td>';
	for ($b=$mes1; $b<=$mes2; $b++)
	{
	  $sqlv="select sum(Can_producto) as cant, sum(prec_producto*Can_producto) as sub 
from det_factura, factura, prodpre, clientes where Factura=Id_fact and  Fech_fact>='$FchIni' and Fech_fact<='$FchFin' and Cod_prese=Cod_producto and month(Fech_fact)=$b and Cod_ant=$codigo_ant and Nit_cliente=Nit_clien and cod_vend=$vendedor;";
//echo $sqlv."<br>";
	  $resultv=mysqli_query($link,$sqlv);
	  $rowv=mysqli_fetch_array($resultv, MYSQLI_BOTH);
	  $cant=$rowv['cant'];
	  $sub=$rowv['sub'];
	  if ($cant==NULL)
	  {
	    $cant=0;
		$sub=0;
	  }
	  echo '<td class="formatoDatos"><div align="center"> '.round($cant).'</div></td>
	  <td class="formatoDatos"><div align="center">$ '.round($sub).'</div></td>';
	}
	echo '</tr>';
	
}
mysqli_free_result($result);
mysqli_free_result($resultv);
/* cerrar la conexión */
mysqli_close($link);
?>

</table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div>
</div>
</body>
</html>