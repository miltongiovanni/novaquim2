<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Inventario de Etiquetas</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="scripts/validar.js"></script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>INVENTARIO DE ETIQUETAS</strong></div>
<table width="700" border="0" align="center">
  <tr> <td width="620" align="right"><form action="Inv_Etiq_Xls.php" method="post" target="_blank">
    <input name="Submit" type="submit" class="resaltado" value="Exportar a Excel"></form></td> 
      <td><div align="right">
          <input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div></td>
  </tr>
</table>
<table border="0" align="center" cellspacing="0" >
<tr>
    <th width="78" class="formatoEncabezados">C&oacute;digo</th>
    <th width="355" class="formatoEncabezados">Etiquetas</th>
    <th width="92" class="formatoEncabezados">Cantidad</th>
  </tr>   
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
$link=conectarServidor();
$sql="	select inv_etiquetas.Cod_etiq as Codigo, Nom_etiq as Producto, inv_etiq as Cantidad from inv_etiquetas, etiquetas
where inv_etiquetas.Cod_etiq=etiquetas.Cod_etiq and inv_etiq > 0;";
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
	<td class="formatoDatos"><div align="center"><script language="javascript"> document.write(commaSplit('.$row['Cantidad'].'))</script></div></td>';
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