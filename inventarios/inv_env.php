<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Inventario de Envase</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="scripts/validar.js"></script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>INVENTARIO DE ENVASE</strong></div>
<table width="712" border="0" align="center" summary="encabezado">
  <tr><td width="620" align="right"><form action="Inv_Env_Xls.php" method="post" target="_blank">
    <input name="Submit" type="submit" class="resaltado" value="Exportar a Excel"></form></td> 
      <td width="97"><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div></td> 
  </tr>
</table>
<table border="0" align="center" cellspacing="0" summary="cuerpo" >
<tr>
    <th width="62" class="formatoEncabezados">C&oacute;digo</th>
    <th width="265" class="formatoEncabezados">Envase</th>
    <th width="95" class="formatoEncabezados">Cantidad</th>
  </tr>   
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
$link=conectarServidor();
//sentencia SQL    tblusuarios.IdUsuario,
$sql="	select invEnvase.Cod_envase as Codigo, Nom_envase as Producto, invEnvase as Cantidad from inv_envase, envase
WHERE inv_envase.codEnvase=envase.Cod_envase;";
$result=mysqli_query($link,$sql);
$a=1;
while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
	if (($row['Cantidad']!=0)&&($row['Codigo']!=0))
	{
	echo'<tr';
	  if (($a++ % 2)==0) echo ' bgcolor="#B4CBEF" ';
	  echo '>
	<td class="formatoDatos"><div align="center">'.$row['Codigo'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Producto'].'</div></td>
	<td class="formatoDatos"><div align="center"><script   > document.write(commaSplit('.$row['Cantidad'].'))</script></div></td>';
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