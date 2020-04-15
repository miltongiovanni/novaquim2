<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Consulta de Venta de Productos por Referencia</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="scripts/validar.js"></script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>CONSULTA DE PRODUCTOS DE DISTRIBUCI&Oacute;N POR MES</strong></div> 

<?php
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 
}  

?>
<table width="85%"  align="center" border="0">
  <tr> 
      <form action="cruce_dist_mes_Xls.php" method="post" target="_blank"><td width="91%" align="right"><input name="Submit" type="submit" class="resaltado" value="Exportar a Excel"></td><input name="FchIni" type="hidden" value="<?php echo $FchIni ?>"><input name="FchFin" type="hidden" value="<?php echo $FchFin ?>"></form>
      <td width="9%"><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div></td>
  </tr>
</table>
<table border="0" align="center" cellspacing="0" width="85%">
  <tr>
    <th class="formatoEncabezados">C&oacute;digo</th>
    <th class="formatoEncabezados">Producto</th>
    <th class="formatoEncabezados">Precio Compra</th>
    <th class="formatoEncabezados">Precio Venta</th>
    <th class="formatoEncabezados">Mes</th>
    <th class="formatoEncabezados">Venta Mes</th>
    <th class="formatoEncabezados">Compra Mes</th>
  </tr>   
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
include "includes/calcularDias.php" ;
$fecha2=explode('-', $FchFin);
$fecha1=explode('-', $FchIni);
$meses=$fecha2[1]-$fecha1[1];
//parametros iniciales que son los que cambiamos
$link=conectarServidor();
$database="novaquim";
//sentencia SQL    tblusuarios.IdUsuario,
$sql="select Id_distribucion, Producto, precio_vta/(1+tasa) as prec_venta, precio_com from distribucion, tasa_iva where Cod_iva=Id_tasa order by Id_distribucion;";
$result=mysqli_query($link,$sql);
$a=1;
while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$codigo=$row['Id_distribucion'];
	$producto=$row['Producto'];
	$PrComp=number_format($row['precio_com'], 0, '.', ',');
	$PrVta=number_format($row['prec_venta'], 0, '.', ',');
	$mes=$fecha1[1];
	for ($b=0; $b<=$meses; $b++)
	{
	  $sqlv="select sum(Can_producto) as ventames from det_factura, factura where fech_fact>='$FchIni' and fech_fact<='$FchFin' and Factura=Id_fact and Cod_producto=$codigo and MONTH(fech_fact)=$mes ;";
	  $resultv=mysqli_query($link,$sqlv);
	  $rowv=mysqli_fetch_array($resultv, MYSQLI_BOTH);
	  $ventames=$rowv['ventames'];
	  if ($ventames==NULL)
	    $ventames=0;
	  $sqlc="select sum(Cantidad) as comprames from compras, det_compras where compras.Id_compra=det_compras.Id_compra and compra=5 and Fech_comp>='$FchIni' and Fech_comp<='$FchFin' and Codigo=$codigo and MONTH(Fech_comp)=$mes ;";
	  $resultc=mysqli_query($link, $sqlc);
	  $rowc=mysqli_fetch_array($resultc, MYSQLI_BOTH);
	  $comprames=round($rowc['comprames'], 0);
	  if ($comprames==NULL)
        $comprames=0;
	  echo'<tr';
	  if (($a++ % 2)==0) echo ' bgcolor="#B4CBEF" ';
	  echo '>
	  <td class="formatoDatos"><div align="center">'.$codigo.'</div></td>
	  <td class="formatoDatos"><div align="left">'.$producto.'</div></td>
	  <td class="formatoDatos"><div align="center">$ '.$PrComp.'</div></td>
	  <td class="formatoDatos"><div align="center">$ '.$PrVta.'</div></td>
	  <td class="formatoDatos"><div align="center">'.$mes++.'</div></td>
	  <td class="formatoDatos"><div align="center">'.$ventames.'</div></td>
	  <td class="formatoDatos"><div align="center">'.$comprames.'</div></td>';
	  echo '</tr>';
	}
	
	
}
mysqli_free_result($result);
mysqli_close($link);//Cerrar la conexion
?>

</table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div>
</div>
</body>
</html>