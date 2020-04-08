<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Consulta de Stock de Etiquetas</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="scripts/validar.js"></script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>CONSULTA DE STOCK DE ETIQUETAS</strong></div>

<table  align="center" width="700" border="0">
  <tr> 
      <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;">
      </div></td>
  </tr>
</table>
<table  border="0" align="center" cellspacing="0" >
<tr>
    <th width="67" class="formatoEncabezados">C&oacute;digo</th>
    <th width="334" class="formatoEncabezados">Etiquetas</th>
    <th width="73" class="formatoEncabezados">Cantidad</th>
    <th width="62" class="formatoEncabezados">Stock</th>
  </tr>   
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
$link=conectarServidor();
$sql="	select inv_etiquetas.Cod_etiq as Codigo, Nom_etiq as Producto, inv_etiq as Cantidad, stock_etiq FROM inv_etiquetas, etiquetas where inv_etiquetas.Cod_etiq=etiquetas.Cod_etiq; ";
$result=mysqli_query($link,$sql);
$a=1;
while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
	if ($row['Cantidad'] < $row['stock_etiq'])
	{
		echo'<tr';
	 	 if (($a++ % 2)==0) echo ' bgcolor="#B4CBEF" ';
	 	 echo '>
		<td class="formatoDatos"><div align="center">'.$row['Codigo'].'</div></td>
		<td class="formatoDatos"><div align="left">'.$row['Producto'].'</div></td>
		<td class="formatoDatos"><div align="center"><script > document.write(commaSplit('.$row['Cantidad'].'))</script></div></td>
		<td class="formatoDatos"><div align="center"><script > document.write(commaSplit('.$row['stock_etiq'].'))</script></div></td>';
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