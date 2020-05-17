<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Consulta de Stock de Productos de Distribuci�n</title>
<meta charset="utf-8">
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>CONSULTA DE STOCK DE ENVASE</strong></div>

<table  align="center" width="700" border="0">
  <tr> 
      <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men�">
      </div></td>
  </tr>
</table>
<table  border="0" align="center" cellspacing="0" >
<tr>
    <th width="67" class="formatoEncabezados">C�digo</th>
    <th width="334" class="formatoEncabezados">Envase</th>
    <th width="73" class="formatoEncabezados">Cantidad</th>
    <th width="62" class="formatoEncabezados">Stock</th>
  </tr>   
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
$link=conectarServidor();
$sql="select distribucion.Id_distribucion as C�digo, Producto, invDistribucion as Inventario, stock_dis as 'Stock M�nimo' 
from distribucion, inv_distribucion where distribucion.Id_distribucion=inv_distribucion.codDistribucion order by Producto; ";
$result=mysqli_query($link,$sql);
$a=1;
while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
	if ($row['Inventario'] < $row['Stock M�nimo'])
	{
		echo'<tr';
	 	 if (($a++ % 2)==0) echo ' bgcolor="#B4CBEF" ';
	 	 echo '>
		<td class="formatoDatos"><div align="center">'.$row['C�digo'].'</div></td>
		<td class="formatoDatos"><div align="left">'.$row['Producto'].'</div></td>
		<td class="formatoDatos"><div align="center"><script > document.write(commaSplit('.$row['Inventario'].'))</script></div></td>
		<td class="formatoDatos"><div align="center"><script > document.write(commaSplit('.$row['Stock M�nimo'].'))</script></div></td>';
		echo'</tr>';
	}
}
mysqli_free_result($result);
/* cerrar la conexi�n */
mysqli_close($link);
?>

</table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men�"></div>
</div>
</body>
</html>