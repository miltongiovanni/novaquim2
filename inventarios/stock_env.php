<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Consulta de Stock de Envase</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="scripts/validar.js"></script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>CONSULTA DE STOCK DE ENVASE</strong></div>

<table  align="center" width="700" border="0">
  <tr> 
      <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;">
      </div></td>
  </tr>
</table>
<table  border="0" align="center" cellspacing="0" >
<tr>
    <th width="67" class="formatoEncabezados">C&oacute;digo</th>
    <th width="334" class="formatoEncabezados">Envase</th>
    <th width="73" class="formatoEncabezados">Cantidad</th>
    <th width="62" class="formatoEncabezados">Stock</th>
  </tr>   
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
$link=conectarServidor();
$sql="	select inv_envase.codEnvase as Codigo, Nom_envase as Producto, invEnvase as Cantidad, stock_envase from inv_envase, envase
WHERE inv_envase.codEnvase=envase.Cod_envase; ";
$result=mysqli_query($link,$sql);
$a=1;
while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
	if ($row['Cantidad'] < $row['stock_envase'])
	{
		echo'<tr';
	 	 if (($a++ % 2)==0) echo ' bgcolor="#B4CBEF" ';
	 	 echo '>
		<td class="formatoDatos"><div align="center">'.$row['Codigo'].'</div></td>
		<td class="formatoDatos"><div align="left">'.$row['Producto'].'</div></td>
		<td class="formatoDatos"><div align="center"><script > document.write(commaSplit('.$row['Cantidad'].'))</script></div></td>
		<td class="formatoDatos"><div align="center"><script > document.write(commaSplit('.$row['stock_envase'].'))</script></div></td>';
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