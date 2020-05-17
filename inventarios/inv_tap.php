<?php
include "../includes/valAcc.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Inventario de Tapas y/o Válvulas</title>
<meta charset="utf-8">
<link href="../css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="../js/validar.js"></script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>INVENTARIO DE TAPAS Y/O VÁLVULAS</strong></div>
<table align="center" width="700" border="0" summary="encabezado">
  <tr><td width="620" align="right"><form action="Inv_Tap_Xls.php" method="post" target="_blank">
    <input name="Submit" type="submit" class="resaltado" value="Exportar a Excel"></form></td>  
      <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú"></div></td>
  </tr>
</table>
<table  border="0" align="center" cellspacing="0" summary="cuerpo" >
<tr>
    <th width="57" class="formatoEncabezados">Código</th>
    <th width="277" class="formatoEncabezados">Envase</th>
    <th width="85" class="formatoEncabezados">Cantidad</th>
  </tr>   
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
$link=conectarServidor();
$sql="SELECT inv_tapas_val.codTapa as Codigo, Nom_tapa as Producto, invTapa as Cantidad from inv_tapas_val, tapas_val where inv_tapas_val.codTapa=tapas_val.Cod_tapa;";
$result=mysqli_query($link,$sql);
$a=1;
while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
	if($row['Cantidad']!=0)
	{
	echo'<tr';
	  if (($a++ % 2)==0) echo ' bgcolor="#B4CBEF" ';
	  echo '>
	<td class="formatoDatos"><div align="center">'.$row['Codigo'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Producto'].'</div></td>
	<td class="formatoDatos"><div align="center"><script  > document.write(commaSplit('.$row['Cantidad'].'))</script></div></td>';
	echo'</tr>';
	}
}
mysqli_free_result($result);
/* cerrar la conexión */
mysqli_close($link);
?>

</table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Menú"></div>
</div>
</body>
</html>