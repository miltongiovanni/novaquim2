<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<title>Seleccionar Materia Prima a revisar Trazabilidad</title>
<script type="text/javascript" src="scripts/validar.js"></script>
<script type="text/javascript" src="scripts/block.js"></script>	
</head>
<body>
<?php
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	//echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 	
}  
	include "includes/conect.php";
	$link=conectarServidor();
	$resultmp=mysqli_query($link,"select Nombre from prodpre where Cod_prese=$Id_Prod");
	$rowmp=mysqli_fetch_array($resultmp);
	$producto=$rowmp['Nombre'];
	mysqli_free_result($resultmp);
?>
<div id="contenedor">
  <div id="saludo1"><strong>TRAZABILIDAD DE <?php echo strtoupper($producto); ?> CON LOTE <?php echo $lote_prod; ?></strong></div>
<table width="700" border="0" align="center">
<tr>
      <td colspan="3" align="left">&nbsp;</td>
</tr>
<tr>
      <td colspan="3" align="left"><div align="left" class="titulo">ENTRADA</div></td>
</tr>
<tr>
      <td width="342" align="center"><strong>Fecha Producci&oacute;n</strong></td><td width="348" align="center"><strong>Unidades</strong></td>
</tr>
<?php
  $qry="select Fch_prod, Can_prese from envasado, ord_prod where envasado.Lote=ord_prod.Lote and Con_prese=$Id_Prod and envasado.Lote=$lote_prod;";	
  $result=mysqli_query($link,$qry);
  while($row=mysqli_fetch_array($result))
  {
	echo '<tr><td align="center">'.$row['Fch_prod'].'</td><td align="center">'.$row['Can_prese'].'</td></tr>';
  }
  mysqli_free_result($result);
?>
</table>  
<table width="700" border="0" align="center">
   <tr>
      <td colspan="4" align="left"><div align="left" class="titulo">SALIDA</div></td>
</tr>
<tr><td width="108" align="center"><strong>Fecha Venta</strong></td><td width="451" align="center"><strong>Cliente</strong></td><td width="127" align="center"><strong>Unidades</strong></td></tr>
<?php
  $qrys="select Fech_remision, Nom_clien, Can_producto from remision, det_remision, clientes where det_remision.Id_remision=remision.Id_remision and Nit_cliente=Nit_clien and Lote_producto=$lote_prod and Cod_producto=$Id_Prod;";
  $results=mysqli_query($link,$qrys);
  while($rows=mysqli_fetch_array($results))
  {
	echo '<tr><td align="center">'.$rows['Fech_remision'].'</td><td align="center">'.$rows['Nom_clien'].'</td><td align="center">'.$rows['Can_producto'].'</td></tr>';
  }
  mysqli_free_result($results);
  mysqli_close($link);
?>
<tr><td>&nbsp;</td></tr>
</table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div>
</div>
</body>
</html>