<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
<title>Seleccionar Materia Prima a revisar Trazabilidad</title>
<script  src="scripts/validar.js"></script>
<script  src="scripts/block.js"></script>
</head>
<body>
<?php
foreach ($_POST as $nombre_campo => $valor) 
{ 
	$asignacion = "\$".$nombre_campo."='".$valor."';"; 
	echo $nombre_campo." = ".$valor."<br>";  
	eval($asignacion); 	
}  
	include "includes/conect.php";
	$link=conectarServidor();
	$resultmp=mysqli_query($link, "select * from mprimas where Cod_mprima=$IdMP");
	$rowmp=mysqli_fetch_array($resultmp);
	$mprima=$rowmp['Nom_mprima'];
	mysqli_free_result($resultmp);
?>
<div id="contenedor">
  <div id="saludo1"><strong>TRAZABILIDAD DE <?php echo mb_strtoupper($mprima); ?> CON LOTE <?php echo $lote_mp; ?></strong></div>
<table width="700" border="0" align="center">
<tr>
      <td colspan="3" align="left">&nbsp;</td>
</tr>

<tr>
      <td colspan="3" align="left"><div align="left" class="titulo">ENTRADA</div></td>
</tr>
<tr>
      <td width="113" align="center"><strong>Fecha Compra</strong></td><td width="465" align="center"><strong>Proveedor</strong></td><td width="108" align="center"><strong>Cantidad (Kg)</strong></td>
</tr>
<?php
  $qry="select fechComp, Nom_provee, Cantidad from det_compras, compras, proveedores where det_compras.idCompra=compras.Id_compra and nit_prov=nitProv and Codigo=$IdMP anD Lote='$lote_mp' order by fechComp;";
  $result=mysqli_query($link,$qry);
  while($row=mysqli_fetch_array($result))
  {
	echo '<tr><td align="center">'.$row['Fech_comp'].'</td><td align="center">'.$row['Nom_provee'].'</td><td align="center">'.$row['Cantidad'].'</td></tr>';
  }
  mysqli_free_result($result);
?>
</table>  
<table width="700" border="0" align="center">
   <tr>
      <td colspan="4" align="left"><div align="left" class="titulo">SALIDA</div></td>
</tr>
<tr><td width="68" align="center"><strong>Lote</strong></td><td width="132" align="center"><strong>Fecha Producci&oacute;n</strong></td><td width="381" align="center"><strong>Producto</strong></td><td width="101" align="center"><strong>Cantidad (Kg)</strong></td>
</tr>
<?php
  $qrys="select ord_prod.Lote, Fch_prod, Nom_produc, Can_mprima from det_ord_prod, ord_prod, productos where det_ord_prod.Lote=ord_prod.Lote and Cod_mprima=$IdMP and Lote_MP='$lote_mp' and Cod_prod=Cod_produc order by ord_prod.Lote;";
  $results=mysqli_query($link,$qrys);
  while($rows=mysqli_fetch_array($results))
  {
	echo '<tr><td align="center">'.$rows['Lote'].'</td><td align="center">'.$rows['Fch_prod'].'</td><td align="center">'.$rows['Nom_produc'].'</td><td align="center">'.$rows['Can_mprima'].'</td></tr>';
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
