<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Inventario de Productos de Distribuci&oacute;n</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="scripts/validar.js"></script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>INVENTARIO DE PRODUCTOS DE DISTRIBUCI&Oacute;N</strong></div>
<table width="727" border="0" align="center" summary="encabezado">
  <tr><td width="620" align="right"><form action="Inv_Dist_Xls.php" method="post" target="_blank">
    <input name="Submit" type="submit" class="resaltado" value="Exportar a Excel"></form></td> 
      <td width="97"><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div></td>
  </tr>
</table>
<table border="0" align="center" cellspacing="0" summary="cuerpo">
<tr>
    <th width="67" class="formatoEncabezados">C&oacute;digo</th>
    <th width="382" class="formatoEncabezados">Producto</th>
    <th width="55" class="formatoEncabezados">Cantidad</th>
  </tr>   
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
$link=conectarServidor();
$sql="	SELECT inv_distribucion.Id_distribucion as Codigo, Producto, inv_dist as Cantidad from inv_distribucion, distribucion
where inv_distribucion.Id_distribucion=distribucion.Id_distribucion and inv_dist >0 and Activo=0 order by Producto;";
$result=mysqli_query($link,$sql); 
$a=1;
while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
	if ($row['Cantidad']!=0)
	{
	echo'<tr';
	  if (($a++ % 2)==0) echo ' bgcolor="#B4CBEF" ';
	  echo '>
	<td class="formatoDatos"><div align="center">'.$row['Codigo'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Producto'].'</div></td>
	<td class="formatoDatos"><div align="center"><script language="javascript" type="text/javascript"> document.write(commaSplit('.$row['Cantidad'].'))</script></div></td>';
	echo'</tr>';
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