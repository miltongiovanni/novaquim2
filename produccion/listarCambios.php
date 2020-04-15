<?php
include "includes/valAcc.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Lista de Cambios de Producto</title>
<meta charset="utf-8">
<link href="css/formatoTabla.css" rel="stylesheet" type="text/css">
	<script  src="scripts/validar.js"></script>
</head>
<body>
<div id="contenedor">
<div id="saludo1"><strong>LISTADO DE CAMBIOS DE PRESENTACI&Oacute;N DE PRODUCTO</strong></div>
<table width="100%" border="0">
  <tr> 
      <td><div align="right"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;">
      </div></td>
  </tr>
</table>
<table border="0" align="center" cellspacing="0">
	<tr>
      <th width="16" class="formatoEncabezados"></th>
      <th width="53" class="formatoEncabezados">Cambio</th>
      <th width="197" class="formatoEncabezados">Fecha del Cambio</th>
      <th width="291" class="formatoEncabezados">Responsable</th>
  </tr>   
<?php
include "includes/utilTabla.php";
include "includes/conect.php" ;
$link=conectarServidor();
$sql="	SELECT Id_cambio, nom_personal, Fech_cambio FROM cambios, personal WHERE Cod_persona=Id_personal order by Id_cambio desc;";
$result=mysqli_query($link, $sql);
$a=1;
while($row=mysqli_fetch_array($result, MYSQLI_BOTH))
{
	$cambio=$row['Id_cambio'];
	echo'<tr';
	  if (($a % 2)==0) echo ' bgcolor="#B4CBEF" ';
	  echo '>
	<td class="formatoDatos"><div align="center"><a aiotitle="click to expand" href="javascript:togglecomments('."'".'UniqueName'.$a."'".')">+/-</a></div></td>
	<td class="formatoDatos"><div align="center">'.$row['Id_cambio'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['Fech_cambio'].'</div></td>
	<td class="formatoDatos"><div align="center">'.$row['nom_personal'].'</div></td>';
	echo'</tr>';
	$sqli="select Id_cambio, Nombre, SUM(Can_prese_ant) as Cantidad FROM det_cambios, prodpre 
	where Id_cambio=$cambio AND Cod_prese_ant=Cod_prese GROUP BY Cod_prese_ant;";
	$resulti=mysqli_query($link, $sqli);
	echo '<tr><td colspan="4"><div class="commenthidden" id="UniqueName'.$a.'"><table width="100%" border="0" align="center" cellspacing="0" bordercolor="#CCCCCC">
	<tr>
		<th width="10%" class="formatoEncabezados">Origen</th>
  	  	<th width="60%" class="formatoEncabezados">Nombre</th>
      	<th width="20%" class="formatoEncabezados">Cantidad</th>
  	</tr>';
	while($rowi=mysqli_fetch_array($resulti, MYSQLI_BOTH))
	{
	echo '<tr>
		<td class="formatoDatos"><div align="left"></div></td>
		<td class="formatoDatos"><div align="left">'.$rowi['Nombre'].'</div></td>
		<td class="formatoDatos"><div align="center"><script > document.write(commaSplit('.$rowi['Cantidad'].'))</script></div></td></tr>';
	}
	echo '<tr>
		<th width="5%" class="formatoEncabezados">Destino</th>
  	  	<th width="20%" class="formatoEncabezados">Nombre</th>
      	<th width="5%" class="formatoEncabezados">Cantidad</th>
  	</tr>';
	$sqli2="select Id_cambio, Nombre, SUM(Can_prese_nvo) as Cantidad FROM det_cambios2, prodpre 
	where Id_cambio=$cambio AND Cod_prese_nvo=Cod_prese GROUP BY Cod_prese_nvo;";
	$resulti2=mysqli_query($link, $sqli2);
	while($rowi2=mysqli_fetch_array($resulti2, MYSQLI_BOTH))
	{
	echo '<tr>
		<td class="formatoDatos"><div align="left"></div></td>
		<td class="formatoDatos"><div align="left">'.$rowi2['Nombre'].'</div></td>
		<td class="formatoDatos"><div align="center"><script > document.write(commaSplit('.$rowi2['Cantidad'].'))</script></div></td></tr>';
	}
	echo '</table></div></td></tr>';
	$a=$a+1;
}
mysqli_free_result($result);
mysqli_free_result($resulti);
mysqli_free_result($resulti2);
mysqli_close($link);//Cerrar la conexion
?>

</table>
<div align="center"><input type="button" class="resaltado" onClick="window.location='menu.php'" value="Ir al Men&uacute;"></div>
</div>
</body>
</html>