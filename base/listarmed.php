<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Listado de Presentaciones de Producto</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="scripts/validar.js"></script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>LISTA DE PRESENTACIONES DE PRODUCTO</strong></div>
<table width="100%" border="0" summary="encabezado">
  <tr> 
      <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;">
      </div></td>
  </tr>
</table>
<table width="1103" align="center" cellspacing="0" summary="cuerpo" >
<tr>
    <th width="71" align="center" class="formatoEncabezados">C&oacute;digo</th>
    <th width="370" align="center" class="formatoEncabezados">Presentaci&oacute;n</th>
    <th width="83" align="center" class="formatoEncabezados">Medida</th>
    <th width="249" align="center" class="formatoEncabezados">Envase</th>
    <th width="207" align="center" class="formatoEncabezados">Tapa</th>
	<th width="109" align="center" class="formatoEncabezados">Cod Anterior</th>
  </tr>   
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
$link=conectarServidor();
$sql="	SELECT Cod_prese AS Codigo, Nombre as 'Presentación',
	des_medida as 'Medida', Nom_envase as 'Envase', Nom_tapa as 'Tapa', cod_ant as 'Codigo Anterior'  
	FROM prodpre, medida, envase, tapas_val, productos
	where medida.Id_medida=prodpre.Cod_umedid and productos.Cod_produc=prodpre.Cod_produc
	and prodpre.Cod_envase=envase.Cod_envase and prodpre.Cod_tapa=tapas_val.Cod_tapa and prod_activo=0 and pres_activo=0
	ORDER BY Nom_produc, cant_medida;";
$result=mysqli_query($link,$sql);
$a=1;
while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$prod=$row['Codigo'];
	echo'<tr';
	  if (($a++ % 2)==0) echo ' bgcolor="#B4CBEF" ';
	  echo '>
	<td class="formatoDatos"><div align="center">'.$row['Codigo'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Presentación'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Medida'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Envase'].'</div></td>
	<td class="formatoDatos"><div align="left">'.$row['Tapa'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Codigo Anterior'].'</div></td>
	';
	echo'</tr>';
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