<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Consulta de Stock de Tapas y/o V&aacute;lvulas</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="scripts/validar.js"></script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>CONSULTA DE STOCK DE TAPAS Y/O V&Aacute;LVULAS</strong></div>

<table align="center" width="700" border="0">
  <tr> 
      <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;">
      </div></td>
  </tr>
</table>
<table border="0" align="center" cellspacing="0">
<tr>
    <th width="70" class="formatoEncabezados">C&oacute;digo</th>
    <th width="294" class="formatoEncabezados">Tapa o V&aacute;lvula</th>
    <th width="90" class="formatoEncabezados">Cantidad</th>
    <th width="87" class="formatoEncabezados">Stock</th>
  </tr>   
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
$link=conectarServidor();
$sql="	select inv_tapas_val.codTapa as Codigo, Nom_tapa as Producto, invTapa as Cantidad, stock_tapa from inv_tapas_val, tapas_val
WHERE inv_tapas_val.codTapa=tapas_val.Cod_tapa; ";
$result=mysqli_query($link,$sql);
$a=1;
while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
	if ($row['Cantidad'] < $row['stock_tapa'])
	{
		echo'<tr';
	 	 if (($a++ % 2)==0) echo ' bgcolor="#B4CBEF" ';
	 	 echo '>
		<td class="formatoDatos"><div align="center">'.$row['Codigo'].'</div></td>
		<td class="formatoDatos"><div align="left">'.$row['Producto'].'</div></td>
		<td class="formatoDatos"><div align="center"><script > document.write(commaSplit('.$row['Cantidad'].'))</script></div></td>
		<td class="formatoDatos"><div align="center"><script > document.write(commaSplit('.$row['stock_tapa'].'))</script></div></td>';
		echo'</tr>';
	}
}
mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
?>

</table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div>
</div>
</body>
</html>